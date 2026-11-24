<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    /**
     * Simpan pengajuan klaim atau tawaran barter baru untuk suatu barang (Task 7).
     */
    public function store(Request $request, Item $item)
    {
        // 1. Validasi Pemilik: Tidak boleh mengklaim barang milik sendiri
        if ($item->user_id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat mengajukan klaim untuk barang milik Anda sendiri.');
        }

        // 2. Validasi Ketersediaan: Barang harus berstatus 'available'
        if ($item->status !== 'available') {
            return back()->with('error', 'Maaf, barang ini sudah tidak tersedia atau telah terkunci.');
        }

        // 3. Validasi Duplikasi: Pengguna tidak boleh mengajukan lebih dari satu klaim pada barang yang sama
        $existingClaim = Claim::where('item_id', $item->id)
            ->where('claimant_id', auth()->id())
            ->first();

        if ($existingClaim) {
            return back()->with('error', 'Anda sudah pernah mengajukan klaim untuk barang ini.');
        }

        // 4. Validasi Input Form
        $rules = [
            'contact_info' => ['required', 'string', 'min:8', 'max:50'],
            'message' => ['required', 'string', 'min:5', 'max:1000'],
        ];

        if ($item->mode === 'barter') {
            $rules['offered_item_desc'] = ['required', 'string', 'min:5', 'max:500'];
        } else {
            $rules['offered_item_desc'] = ['nullable', 'string', 'max:500'];
        }

        $messages = [
            'contact_info.required' => 'Nomor kontak / WhatsApp aktif wajib diisi.',
            'contact_info.min' => 'Nomor kontak minimal 8 digit.',
            'message.required' => 'Pesan singkat atau alasan kebutuhan wajib diisi.',
            'message.min' => 'Pesan singkat minimal 5 karakter.',
            'offered_item_desc.required' => 'Deskripsikan barang yang Anda tawarkan untuk barter.',
        ];

        $validated = $request->validate($rules, $messages);

        // 5. Simpan Klaim
        Claim::create([
            'item_id' => $item->id,
            'claimant_id' => auth()->id(),
            'contact_info' => $validated['contact_info'],
            'message' => $validated['message'],
            'offered_item_desc' => $item->mode === 'barter' ? $validated['offered_item_desc'] : null,
            'status' => 'pending',
        ]);

        return redirect()->route('items.show', $item)
            ->with('success', 'Permohonan klaim berhasil dikirim! Silakan pantau perkembangannya di menu Pengajuan Saya.');
    }

    /**
     * Tampilkan daftar pengajuan masuk untuk barang yang dipasang oleh pengguna (Task 8).
     */
    public function incoming(Request $request)
    {
        $userItemIds = auth()->user()->items()->pluck('id');

        $query = Claim::whereIn('item_id', $userItemIds)
            ->with(['item.images', 'item.primaryImage', 'claimant']);

        // Filter berdasarkan Status
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan Barang Spesifik
        if ($request->filled('item_id') && is_numeric($request->item_id)) {
            $query->where('item_id', $request->item_id);
        }

        $claims = $query->latest()->paginate(8)->withQueryString();

        // Hitung Statistik Tab
        $totalCount = Claim::whereIn('item_id', $userItemIds)->count();
        $pendingCount = Claim::whereIn('item_id', $userItemIds)->where('status', 'pending')->count();
        $approvedCount = Claim::whereIn('item_id', $userItemIds)->where('status', 'approved')->count();
        $rejectedCount = Claim::whereIn('item_id', $userItemIds)->where('status', 'rejected')->count();

        // Daftar barang user untuk dropdown filter
        $myItems = auth()->user()->items()->select('id', 'title')->get();

        return view('claims.incoming', compact(
            'claims',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount',
            'myItems'
        ));
    }

    /**
     * Setujui pengajuan klaim secara atomik & kunci ketersediaan barang (Task 8 - Atomic Lock Engine).
     */
    public function approve(Request $request, Claim $claim)
    {
        // Pastikan hanya pemilik barang yang dapat menyetujui klaim
        $claim->load('item');
        if ($claim->item->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda bukan pemilik dari barang ini.');
        }

        if ($claim->status !== 'pending') {
            return back()->with('error', 'Hanya pengajuan dengan status menunggu yang dapat disetujui.');
        }

        // Jalankan transaksi database atomik dengan pesimistic row locking
        try {
            DB::transaction(function () use ($claim) {
                // Kunci baris item untuk mencegah race-condition multi approval
                $item = Item::where('id', $claim->item_id)->lockForUpdate()->firstOrFail();

                if ($item->status !== 'available') {
                    throw new \Exception('Barang ini sudah tidak dalam status tersedia atau telah disetujui sebelumnya.');
                }

                // 1. Kunci status barang
                $item->update(['status' => 'locked']);

                // 2. Setujui klaim terpilih
                $claim->update(['status' => 'approved']);

                // 3. Otomatis tolak semua klaim pending lainnya untuk barang yang sama (FR-08)
                Item::find($claim->item_id)
                    ->claims()
                    ->where('id', '!=', $claim->id)
                    ->where('status', 'pending')
                    ->update(['status' => 'rejected']);
            });

            return back()->with('success', 'Pengajuan berhasil disetujui! Status barang otomatis terkunci dan kontak WhatsApp mahasiswa peminat telah terbuka.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses persetujuan: '.$e->getMessage());
        }
    }

    /**
     * Tolak pengajuan klaim tertentu (Task 8).
     */
    public function reject(Request $request, Claim $claim)
    {
        $claim->load('item');
        if ($claim->item->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak. Anda bukan pemilik dari barang ini.');
        }

        if ($claim->status !== 'pending') {
            return back()->with('error', 'Pengajuan ini sudah diproses sebelumnya.');
        }

        $claim->update(['status' => 'rejected']);

        return back()->with('info', 'Pengajuan mahasiswa tersebut telah ditolak.');
    }

    /**
     * Tampilkan seluruh pengajuan yang pernah diajukan oleh pengguna yang login (Task 9).
     */
    public function myClaims(Request $request)
    {
        $query = Claim::where('claimant_id', auth()->id())
            ->with(['item.user', 'item.images', 'item.primaryImage']);

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $claims = $query->latest()->paginate(8)->withQueryString();

        $totalCount = Claim::where('claimant_id', auth()->id())->count();
        $pendingCount = Claim::where('claimant_id', auth()->id())->where('status', 'pending')->count();
        $approvedCount = Claim::where('claimant_id', auth()->id())->where('status', 'approved')->count();
        $rejectedCount = Claim::where('claimant_id', auth()->id())->where('status', 'rejected')->count();

        return view('claims.my-claims', compact(
            'claims',
            'totalCount',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
    }
}
