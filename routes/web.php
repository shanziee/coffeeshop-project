<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController; // <-- Baru (Langkah 4)
use App\Http\Controllers\Admin\AuthController as AdminAuthController; // Alias untuk Admin Auth
use App\Http\Controllers\Admin\DashboardController; // Baru (Langkah 3)

/*
|--------------------------------------------------------------------------
| Public Routes & Pelanggan Routes
|--------------------------------------------------------------------------
*/

// Halaman utama
Route::get('/', [MenuController::class, 'showMenu'])->name('menu');

// Rute Checkout (Membutuhkan Login)
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Autentikasi Pelanggan (Juga bisa digunakan Admin)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']); // Sudah diperbarui untuk handle Admin/User

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

// Logout Pelanggan
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute Notifikasi Midtrans (Public, tidak butuh login)
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])->name('midtrans.callback'); // <-- Baru (Langkah 4)

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Rute ini dilindungi oleh guard 'admin'.
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // --- Rute Login Admin (Masih dipertahankan, walau sudah bisa via /login) ---
    // Gunakan middleware guest:admin agar yang sudah login tidak bisa akses
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    // --- Rute yang Hanya Bisa Diakses Admin ---
    // Gunakan middleware auth:admin agar hanya admin yang bisa akses
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard Admin (Langkah 3)
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Rute lain untuk CRUD Product, dll. bisa ditambahkan di sini.
    });
});
