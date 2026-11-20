<?php

namespace App\Http\Controllers;

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

        return view('dashboard', compact('recentItems', 'categories', 'userSharedCount'));
    }
}
