<?php

use App\Http\Controllers\AlamatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

// '/' (Fathir): user login -> katalog produk, tamu -> dilempar auth ke /login. Loop redirect kemarin mati di sini.
Route::middleware('auth')->group(function (): void {
    Route::get('/', function () {
        return redirect()->route('produk.index');
    });
});

// Login/logout pakai auth kamu (guest + throttle + MasterAdmin)
Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:5,1')
        ->name('login.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware('master.admin')->group(function (): void {
        Route::resource('layanan', LayananController::class)->except('show');
    });

    // Katalog Produk (Fathir) — lihat katalog butuh login, tambah/edit/hapus khusus admin
    Route::get('produk', [ProdukController::class, 'index'])->name('produk.index');

    Route::middleware('admin')->group(function (): void {
        Route::resource('produk', ProdukController::class)->except(['index', 'show']);
    });
});

// Voucher & Promo (Rahma)
Route::get('/e-commers', [VoucherController::class, 'index'])->name('voucher.index');
Route::get('/input-promo', [VoucherController::class, 'manage'])->name('voucher.manage');
Route::post('/vouchers', [VoucherController::class, 'store'])->name('voucher.store');
Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('voucher.update');
Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');

// Profil Pelanggan & Alamat (Alvin)
Route::get('/form', [ProfilController::class, 'create'])->name('form');
Route::resource('profil', ProfilController::class)->except(['create', 'show']);
Route::resource('alamat', AlamatController::class)->except(['create', 'show']);