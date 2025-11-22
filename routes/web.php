<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Public Routes & Pelanggan Routes
|--------------------------------------------------------------------------
*/

// Halaman utama (Menu & Cart)
Route::get('/', [MenuController::class, 'showMenu'])->name('menu');

// Rute Checkout (Membutuhkan Login Pelanggan)
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Autentikasi Pelanggan (User Biasa)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'loginProcess']); // Login User & Admin lewat sini

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'registerProcess'])->name('register.process');
});

// Logout (Berlaku untuk User & Admin yang login via web guard)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Rute Notifikasi Midtrans (Public, dikecualikan dari CSRF biasanya)
Route::post('/midtrans/callback', [MidtransController::class, 'callback'])->name('midtrans.callback');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
| Rute ini dilindungi oleh guard 'admin' & prefix 'admin'.
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // --- Rute Login Khusus Admin (Opsional, karena sudah bisa via /login utama) ---
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    // --- Rute Terproteksi Khusus Admin ---
    Route::middleware('auth:admin')->group(function () {

        // Logout Khusus Admin
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard Admin
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Fitur Kelola Pesanan (Baru)
        // 1. Tandai Lunas (Paid)
        Route::post('orders/{id}/mark-paid', [DashboardController::class, 'markAsPaid'])->name('orders.markPaid');

        // 2. Cetak Struk (Thermal Printer)
        Route::get('orders/{id}/print', [DashboardController::class, 'printReceipt'])->name('orders.print');

        // Rute CRUD Menu (Opsional, jika nanti dibuat)
        // Route::resource('products', ProductController::class);
    });
});
