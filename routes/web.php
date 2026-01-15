<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PenjualController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\QRCodeController;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', function () {
    $user = Auth::user();

    if ($user && $user->role === 'penjual') {
        return redirect()->route('penjual.dashboard');
    }

    if ($user && $user->role === 'admin') {
        return redirect('/admin');
    }

    // default: mahasiswa
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// QR
Route::get('/qrcode', [QRCodeController::class, 'generate'])->name('qrcode');

// Pesan makanan (hasil scan QR)
Route::get('/pesan', [MenuController::class, 'index'])->name('pesan');

// ================== ORDER (DB cart) ==================
Route::post('/order/tambah', [OrderController::class, 'tambah'])->name('keranjang.tambah');
Route::get('/keranjang', [OrderController::class, 'keranjang'])->name('keranjang');
Route::post('/order/checkout', [OrderController::class, 'checkout'])->name('order.checkout'); // kalau method ini ada

// Auth common
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pesanan-saya', [PesananController::class, 'saya'])->name('pesanan.saya');

    Route::post('/meja/reset', function () {
        session()->forget('meja_aktif');
        return redirect('/dashboard');
    })->name('meja.reset');
});

// Penjual
Route::middleware(['auth', 'role:penjual'])->group(function () {
    Route::get('/penjual', function () {
        return view('penjual.dashboard');
    });

    Route::get('/penjual/dashboard', [PenjualController::class, 'dashboard'])->name('penjual.dashboard');
    Route::post('/penjual/order/{id}/proses', [PenjualController::class, 'proses'])->name('penjual.order.proses');
    Route::post('/penjual/order/{id}/selesai', [PenjualController::class, 'selesai'])->name('penjual.order.selesai');
});

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin', fn () => view('admin.dashboard'));
});

// QR per meja (gambar QR)
Route::get('/qrcode/meja/{meja}', [QRCodeController::class, 'meja'])->name('qrcode.meja');

Route::delete('/penjual/order/{id}/hapus', [PenjualController::class, 'hapus'])->name('penjual.order.hapus');

Route::delete('/order/{id}/hapus', [OrderController::class, 'hapus'])->name('order.hapus');

require __DIR__.'/auth.php';
