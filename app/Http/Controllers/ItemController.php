<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Tampilkan katalog Jelajahi Barang dengan filter & pencarian.
     */
    public function index(Request $request)
    {
        $query = Item::with(['user', 'primaryImage', 'images']);

        // 1. Pencarian Teks
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('barter_request', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // 2. Filter Mode Transaksi
        if ($request->filled('mode') && in_array($request->mode, ['gratis', 'harga_pas', 'barter'])) {
            $query->where('mode', $request->mode);
        }

        // 3. Filter Kategori
        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', 'like', "%{$request->category}%");
        }

        // 4. Filter Kondisi Barang
        if ($request->filled('condition') && $request->condition !== 'Semua') {
            $query->where('condition', $request->condition);
        }

        // 5. Filter Fakultas Pemilik
        if ($request->filled('faculty') && $request->faculty !== 'Semua') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('faculty', $request->faculty);
            });
        }

        // 6. Hanya Tampilkan yang Tersedia
        if ($request->boolean('available_only')) {
            $query->where('status', 'available');
        }

        // 7. Urutan (Sorting)
        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }

        $items = $query->paginate(6)->withQueryString();

        // Data Statistik untuk Header Katalog
        $totalListing = Item::count();
        $gratisCount = Item::where('mode', 'gratis')->count();
        $hargaPasCount = Item::where('mode', 'harga_pas')->count();
        $barterCount = Item::where('mode', 'barter')->count();
        $fakultasCount = User::whereNotNull('faculty')->distinct('faculty')->count('faculty');

        $faculties = ['Fasilkom', 'Farmasi', 'Teknik Mesin', 'Ilmu Hukum', 'Kedokteran', 'Teknik Elektro', 'Ekonomi & Bisnis', 'MIPA'];

        return view('items.index', compact(
            'items',
            'totalListing',
            'gratisCount',
            'hargaPasCount',
            'barterCount',
            'fakultasCount',
            'faculties'
        ));
    }

    /**
     * Tampilkan detail barang lengkap dengan galeri foto, profil pemilik, dan status aksi.
     */
    public function show(Item $item)
    {
        $item->load(['user', 'images', 'claims']);

        // Cek apakah mahasiswa yang sedang login sudah pernah mengajukan klaim untuk barang ini
        $userClaim = auth()->check()
            ? $item->claims->firstWhere('claimant_id', auth()->id())
            : null;

        // Ambil barang terkait dari kategori yang sama
        $relatedItems = Item::with(['user', 'primaryImage', 'images'])
            ->where('id', '!=', $item->id)
            ->where('status', 'available')
            ->where('category', $item->category)
            ->latest()
            ->take(3)
            ->get();

        // Jika barang dalam kategori yang sama kurang dari 3, lengkapi dengan barang terbaru lainnya
        if ($relatedItems->count() < 3) {
            $excludeIds = $relatedItems->pluck('id')->push($item->id);
            $additionalItems = Item::with(['user', 'primaryImage', 'images'])
                ->whereNotIn('id', $excludeIds)
                ->where('status', 'available')
                ->latest()
                ->take(3 - $relatedItems->count())
                ->get();
            $relatedItems = $relatedItems->concat($additionalItems);
        }

        return view('items.show', compact('item', 'userClaim', 'relatedItems'));
    }

    /**
     * Tampilkan form pasang barang baru.
     */
    public function create()
    {
        $categories = [
            'Elektronik & Gadget Belajar',
            'Buku & Modul',
            'Perlengkapan Kuliah',
            'Fashion & Jaket',
            'Alat Praktikum',
            'Lainnya',
        ];

        $conditions = [
            'Baru (Gress)' => 'Belum pernah dibuka/dipakai, segel masih utuh.',
            'Seperti Baru' => 'Hanya dipakai beberapa kali, mulus tanpa cacat.',
            'Bekas Layak Pakai' => 'Fungsi 100% normal, ada tanda pemakaian wajar.',
            'Ada Kekurangan' => 'Ada baret atau fungsi sampingan yang minus tapi masih bisa pakai.',
        ];

        return view('items.create', compact('categories', 'conditions'));
    }

    /**
     * Simpan barang baru ke database dan upload foto.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'condition' => ['required', 'string', 'in:Baru (Gress),Seperti Baru,Bekas Layak Pakai,Ada Kekurangan'],
            'description' => ['required', 'string', 'max:1000'],
            'mode' => ['required', 'in:gratis,harga_pas,barter'],
            'price' => ['nullable', 'required_if:mode,harga_pas', 'numeric', 'min:0'],
            'barter_request' => ['nullable', 'required_if:mode,barter', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:500'],
            'meetup_location' => ['nullable', 'string', 'max:255'],
            'time_handover' => ['nullable', 'string', 'max:255'],
            'photos' => ['nullable', 'array', 'max:3'],
            'photos.*' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
        ], [
            'title.required' => 'Judul barang wajib diisi.',
            'category.required' => 'Pilih kategori barang.',
            'condition.required' => 'Pilih kondisi barang.',
            'description.required' => 'Deskripsi barang wajib diisi.',
            'mode.required' => 'Pilih format transaksi (Gratis / Harga Pas / Barter).',
            'price.required_if' => 'Nominal harga wajib diisi jika memilih mode Harga Pas.',
            'barter_request.required_if' => 'Tuliskan barang yang ingin kamu tukar jika memilih mode Barter.',
            'contact_info.required' => 'Informasi kontak & lokasi COD wajib diisi.',
            'photos.max' => 'Maksimal 3 foto yang dapat diunggah.',
            'photos.*.image' => 'File harus berupa gambar (JPG, PNG, atau WEBP).',
            'photos.*.max' => 'Ukuran setiap foto maksimal 2MB.',
        ]);

        $item = auth()->user()->items()->create([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'condition' => $validated['condition'],
            'description' => $validated['description'],
            'mode' => $validated['mode'],
            'price' => $validated['mode'] === 'harga_pas' ? $validated['price'] : null,
            'barter_request' => $validated['mode'] === 'barter' ? $validated['barter_request'] : null,
            'contact_info' => $validated['contact_info'],
            'meetup_location' => $validated['meetup_location'] ?? null,
            'time_handover' => $validated['time_handover'] ?? null,
            'status' => 'available',
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $photo->store('items', 'public');
                $item->images()->create([
                    'image_path' => $path,
                    'is_primary' => $index === 0,
                ]);
            }
        } else {
            // Gunakan SVG default dari tema waris.in
            $item->images()->create([
                'image_path' => 'images/placeholders/default.svg',
                'is_primary' => true,
            ]);
        }

        return redirect()->route('items.show', $item)
            ->with('success', 'Barang berhasil dipublikasikan ke katalog waris.in!');
    }

    /**
     * Tampilkan daftar barang milik pengguna yang sedang login (Task 6).
     */
    public function myItems(Request $request)
    {
        $query = auth()->user()->items()->with(['images', 'primaryImage', 'claims']);

        if ($request->filled('status') && in_array($request->status, ['available', 'locked'])) {
            $query->where('status', $request->status);
        }

        $items = $query->latest()->paginate(8)->withQueryString();

        $totalItems = auth()->user()->items()->count();
        $availableItems = auth()->user()->items()->where('status', 'available')->count();
        $lockedItems = auth()->user()->items()->where('status', 'locked')->count();
        $totalClaimsReceived = Claim::whereIn('item_id', auth()->user()->items()->pluck('id'))->count();

        return view('items.my-items', compact(
            'items',
            'totalItems',
            'availableItems',
            'lockedItems',
            'totalClaimsReceived'
        ));
    }

    /**
     * Tampilkan formulir edit barang (Task 6).
     */
    public function edit(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengedit barang milik pengguna lain.');
        }

        $categories = [
            'Elektronik & Gadget Belajar',
            'Buku & Modul',
            'Perlengkapan Kuliah',
            'Fashion & Jaket',
            'Alat Praktikum',
            'Lainnya',
        ];

        $conditions = [
            'Baru (Gress)' => 'Belum pernah dibuka/dipakai, segel masih utuh.',
            'Seperti Baru' => 'Hanya dipakai beberapa kali, mulus tanpa cacat.',
            'Bekas Layak Pakai' => 'Fungsi 100% normal, ada tanda pemakaian wajar.',
            'Ada Kekurangan' => 'Ada baret atau fungsi sampingan yang minus tapi masih bisa pakai.',
        ];

        return view('items.edit', compact('item', 'categories', 'conditions'));
    }

    /**
     * Perbarui data barang (Task 6).
     */
    public function update(Request $request, Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak mengedit barang milik pengguna lain.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:100'],
            'condition' => ['required', 'string', 'in:Baru (Gress),Seperti Baru,Bekas Layak Pakai,Ada Kekurangan'],
            'condition_note' => ['nullable', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:1000'],
            'mode' => ['required', 'in:gratis,harga_pas,barter'],
            'price' => ['nullable', 'required_if:mode,harga_pas', 'numeric', 'min:0'],
            'barter_request' => ['nullable', 'required_if:mode,barter', 'string', 'max:255'],
            'contact_info' => ['required', 'string', 'max:500'],
            'meetup_location' => ['nullable', 'string', 'max:255'],
            'time_handover' => ['nullable', 'string', 'max:255'],
        ]);

        $item->update([
            'title' => $validated['title'],
            'category' => $validated['category'],
            'condition' => $validated['condition'],
            'condition_note' => $validated['condition_note'] ?? null,
            'description' => $validated['description'],
            'mode' => $validated['mode'],
            'price' => $validated['mode'] === 'harga_pas' ? $validated['price'] : null,
            'barter_request' => $validated['mode'] === 'barter' ? $validated['barter_request'] : null,
            'contact_info' => $validated['contact_info'],
            'meetup_location' => $validated['meetup_location'] ?? null,
            'time_handover' => $validated['time_handover'] ?? null,
        ]);

        return redirect()->route('items.my')
            ->with('success', 'Data barang berhasil diperbarui!');
    }

    /**
     * Hapus barang milik pengguna (Task 6).
     */
    public function destroy(Item $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Anda tidak berhak menghapus barang milik pengguna lain.');
        }

        // Hapus barang beserta relasi foto cascade
        $item->delete();

        return redirect()->route('items.my')
            ->with('success', 'Barang berhasil dihapus dari daftar barang Anda.');
    }
}
