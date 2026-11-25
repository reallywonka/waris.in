<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman Beranda utama waris.in.
     */
    public function index(Request $request)
    {
        // Ambil 6 listing terbaru lengkap dengan relasi pemilik dan foto
        $recentItems = Item::with(['user', 'primaryImage', 'images'])
            ->latest()
            ->take(6)
            ->get();

        $categories = [
            'Buku & Modul',
            'Elektronik',
            'Perlengkapan Kuliah',
            'Fashion & Jaket',
            'Alat Praktikum',
            'Lainnya',
        ];

        // Hitung jejak kebaikan user yang sedang login (berapa barang yang pernah dia pasang)
        $userSharedCount = auth()->check() ? auth()->user()->items()->count() : 0;

        // Ambil barang milik pengguna yang sedang login untuk tracking progres & peminat langsung di beranda
        $myItems = auth()->check()
            ? auth()->user()->items()
                ->with(['claims', 'primaryImage', 'images'])
                ->latest()
                ->take(4)
                ->get()
            : collect();

        $myActiveCount = auth()->check() ? auth()->user()->items()->where('status', 'available')->count() : 0;
        $myPendingClaimsCount = auth()->check()
            ? Claim::whereHas('item', fn ($q) => $q->where('user_id', auth()->id()))
                ->where('status', 'pending')
                ->count()
            : 0;

        return view('dashboard', compact(
            'recentItems',
            'categories',
            'userSharedCount',
            'myItems',
            'myActiveCount',
            'myPendingClaimsCount'
        ));
    }
}
