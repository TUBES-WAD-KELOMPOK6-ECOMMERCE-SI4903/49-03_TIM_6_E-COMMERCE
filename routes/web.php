<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

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
});

// Voucher & Promo (Rahma) — route '/' TIDAK diambil, tetap redirect ke /login
Route::get('/e-commers', [VoucherController::class, 'index'])->name('voucher.index');
Route::get('/input-promo', [VoucherController::class, 'manage'])->name('voucher.manage');
Route::post('/vouchers', [VoucherController::class, 'store'])->name('voucher.store');
Route::put('/vouchers/{id}', [VoucherController::class, 'update'])->name('voucher.update');
Route::delete('/vouchers/{id}', [VoucherController::class, 'destroy'])->name('voucher.destroy');