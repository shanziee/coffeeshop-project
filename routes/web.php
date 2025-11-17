<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- IMPORT CONTROLLER KITA ---

// Controller untuk Halaman Pelanggan
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AuthController; // Untuk login/register pelanggan

// Controller untuk Halaman Admin
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;


// --- RUTE PELANGGAN (YANG DILIHAT PENGUNJUNG) ---

// Halaman Utama (Menu)
// URL: /
Route::get('/', [MenuController::class, 'showMenu'])->name('menu');

// Halaman Login Pelanggan
// URL: /login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'loginProcess']);

// Halaman Registrasi Pelanggan
// URL: /register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'registerProcess']);

// Rute Logout Pelanggan
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// --- RUTE KHUSUS ADMIN (YANG DILIHAT ADMIN) ---

Route::prefix('admin')->name('admin.')->group(function () {

    // Halaman login admin
    // URL: /admin/login
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Halaman yang butuh login admin
    Route::middleware('auth:admin')->group(function () {

        // Halaman dashboard admin
        // URL: /admin/dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // (Nanti tambahkan rute kelola menu, kelola pesanan, dll di sini)
    });
});
