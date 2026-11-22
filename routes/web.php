<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - waris.in
|--------------------------------------------------------------------------
*/

// Beranda Utama (Bisa diakses publik atau setelah login)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Katalog Jelajahi Barang
Route::get('/jelajahi', [ItemController::class, 'index'])->name('items.index');
Route::get('/barang/{item}', [ItemController::class, 'show'])->name('items.show');

// Rute yang membutuhkan Login Mahasiswa
Route::middleware(['auth'])->group(function () {
    // Pengaturan Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
