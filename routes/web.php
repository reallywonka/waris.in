<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClaimController;
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
    // Pasang Barang (Create & Store - Task 5)
    Route::get('/pasang-barang', [ItemController::class, 'create'])->name('items.create');
    Route::post('/pasang-barang', [ItemController::class, 'store'])->name('items.store');

    // Manajemen Barang Saya (Task 6)
    Route::get('/barang-saya', [ItemController::class, 'myItems'])->name('items.my');
    Route::get('/barang/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/barang/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/barang/{item}', [ItemController::class, 'destroy'])->name('items.destroy');

    // Pengajuan Klaim & Tawaran Barter (Task 7)
    Route::post('/barang/{item}/klaim', [ClaimController::class, 'store'])->name('claims.store');

    // Dashboard Pengajuan Masuk & Approval Atomic (Task 8)
    Route::get('/pengajuan-masuk', [ClaimController::class, 'incoming'])->name('claims.incoming');
    Route::post('/pengajuan/{claim}/setujui', [ClaimController::class, 'approve'])->name('claims.approve');
    Route::post('/pengajuan/{claim}/tolak', [ClaimController::class, 'reject'])->name('claims.reject');

    // Dashboard Pengajuan Saya & Unlocked Contact (Task 9)
    Route::get('/pengajuan-saya', [ClaimController::class, 'myClaims'])->name('claims.my');

    // Pengaturan Profil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Portal Moderasi Admin Kampus (Task 10 - FR-10 & FR-11)
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::delete('/barang/{item}', [AdminController::class, 'destroyItem'])->name('items.destroy');
        Route::post('/pengguna/{user}/suspend', [AdminController::class, 'suspendUser'])->name('users.suspend');
        Route::post('/pengguna/{user}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
    });
});

require __DIR__.'/auth.php';
