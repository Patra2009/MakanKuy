<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LingkaranController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\PromoController;
use App\Http\Controllers\Admin\PenggunaController;
use App\Http\Controllers\Admin\KontakController;

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::post('/pesanan', [LandingController::class, 'storePesanan'])->name('pesanan.store');
Route::post('/pesanan/status', [LandingController::class, 'statusPesanan'])->name('pesanan.status');
Route::post('/kontak', [LandingController::class, 'storeKontak'])->name('kontak.store');

// Lingkaran (existing)
Route::get('/lingkaran', [LingkaranController::class, 'index']);
Route::post('/lingkaran', [LingkaranController::class, 'hitung'])->name('lingkaran.hitung');

// Admin Panel
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{pesanan}', [PesananController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{pesanan}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');

    // Menu
    Route::resource('menu', MenuController::class)->except(['show']);

    // Kategori
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');

    // Promo
    Route::post('/promo', [PromoController::class, 'store'])->name('promo.store');
    Route::put('/promo/{promo}', [PromoController::class, 'update'])->name('promo.update');
    Route::delete('/promo/{promo}', [PromoController::class, 'destroy'])->name('promo.destroy');
    Route::get('/promo', [PromoController::class, 'index'])->name('promo.index');

    // Pengguna
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');

    // Kontak
    Route::get('/kontak', [KontakController::class, 'index'])->name('kontak.index');
});
