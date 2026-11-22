<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Tampilkan Portal Moderasi Admin Kampus (Task 10).
     */
    public function dashboard(Request $request)
    {
        $tab = $request->get('tab', 'items');

        // Ringkasan Statistik Platform
        $totalStudents = User::where('role', 'mahasiswa')->count();
        $totalItems = Item::count();
        $activeItems = Item::where('status', 'available')->count();
        $lockedItems = Item::where('status', 'locked')->count();
        $suspendedStudents = User::where('status', 'suspended')->count();

        // Query Tab 1: Moderasi Listing Barang
        $itemsQuery = Item::with(['user', 'primaryImage', 'claims']);

        if ($request->filled('item_search')) {
            $search = $request->item_search;
            $itemsQuery->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($uq) => $uq->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('item_status') && in_array($request->item_status, ['available', 'locked'])) {
            $itemsQuery->where('status', $request->item_status);
        }

        if ($request->filled('item_mode') && in_array($request->item_mode, ['gratis', 'harga_pas', 'barter'])) {
            $itemsQuery->where('mode', $request->item_mode);
        }

        $items = $itemsQuery->latest()->paginate(8, ['*'], 'items_page')->withQueryString();

        // Query Tab 2: Moderasi Akun Mahasiswa
        $usersQuery = User::where('role', 'mahasiswa')->withCount(['items', 'claims']);

        if ($request->filled('user_search')) {
            $search = $request->user_search;
            $usersQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nim', 'like', "%{$search}%");
            });
        }

        if ($request->filled('user_status') && in_array($request->user_status, ['active', 'suspended'])) {
            $usersQuery->where('status', $request->user_status);
        }

        if ($request->filled('user_faculty') && $request->user_faculty !== 'Semua') {
            $usersQuery->where('faculty', $request->user_faculty);
        }

        $users = $usersQuery->latest()->paginate(8, ['*'], 'users_page')->withQueryString();

        $faculties = ['Fasilkom', 'Farmasi', 'Teknik Mesin', 'Ilmu Hukum', 'Kedokteran', 'Teknik Elektro', 'Ekonomi & Bisnis', 'MIPA'];

        return view('admin.dashboard', compact(
            'tab',
            'totalStudents',
            'totalItems',
            'activeItems',
            'lockedItems',
            'suspendedStudents',
            'items',
            'users',
            'faculties'
        ));
    }

    /**
     * Hapus paksa listing barang yang melanggar aturan komunitas (FR-10).
     */
    public function destroyItem(Request $request, Item $item)
    {
        $itemTitle = $item->title;
        $ownerName = $item->user->name ?? 'Mahasiswa';

        // Hapus file gambar terkait di public storage bila ada
        foreach ($item->images as $img) {
            if ($img->image_path && !str_starts_with($img->image_path, 'images/placeholders/')) {
                Storage::disk('public')->delete($img->image_path);
            }
        }

        $item->delete();

        return back()->with('success', "Listing '{$itemTitle}' milik {$ownerName} berhasil dihapus permanen dari platform.");
    }

    /**
     * Tangguhkan (Suspend) akun pengguna yang bermasalah beserta alasan penangguhan (FR-11).
     */
    public function suspendUser(Request $request, User $user)
    {
        if ($user->isAdmin() || $user->id === auth()->id()) {
            return back()->with('error', 'Aksi ditolak. Tidak dapat menangguhkan akun administrator.');
        }

        $validated = $request->validate([
            'suspend_reason' => ['required', 'string', 'min:5', 'max:500'],
        ], [
            'suspend_reason.required' => 'Alasan penangguhan akun wajib diisi.',
            'suspend_reason.min' => 'Alasan penangguhan minimal 5 karakter.',
        ]);

        $user->update([
            'status' => 'suspended',
            'suspend_reason' => $validated['suspend_reason'],
        ]);

        return back()->with('success', "Akun mahasiswa {$user->name} berhasil ditangguhkan.");
    }

    /**
     * Pulihkan akun pengguna yang sebelumnya ditangguhkan menjadi aktif kembali.
     */
    public function activateUser(Request $request, User $user)
    {
        $user->update([
            'status' => 'active',
            'suspend_reason' => null,
        ]);

        return back()->with('success', "Status akun mahasiswa {$user->name} berhasil dipulihkan menjadi aktif kembali.");
    }
}
