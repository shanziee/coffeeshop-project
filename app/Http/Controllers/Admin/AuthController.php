<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PENTING UNTUK LOGIN

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin.
     * (File: resources/views/admin/login.blade.php)
     */
    public function showLoginForm()
    {
        // Anda perlu membuat file view ini
        return view('admin.login');
    }

    /**
     * Memproses data login dari admin.
     */
    public function login(Request $request)
    {
        // 1. Validasi data
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Coba login menggunakan 'guard' admin
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Jika berhasil, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // 4. Jika gagal, kembali ke login admin dengan pesan error
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    /**
     * Memproses logout admin
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Arahkan kembali ke halaman login admin
        return redirect(route('admin.login'));
    }
}
