<?php

namespace App\Http\Controllers;

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
}
