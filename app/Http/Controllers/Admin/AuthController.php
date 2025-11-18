<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman login admin.
     */
    public function showLoginForm()
    {
        return view('admin.login');
    }

    /**
     * Memproses data login dari admin.
     */
    public function login(Request $request)
    {
        // 1. Validasi data (menggunakan 'email' untuk format yang benar)
        $credentials = $request->validate([
            'email' => 'required|email|string', // <-- VALIDASI MENGGUNAKAN EMAIL
            'password' => 'required|string',
        ]);

        // 2. Petakan input 'email' dari form ke kolom 'username' di database
        $loginCredentials = [
            'username' => $credentials['email'], // <-- MENGGUNAKAN KOLOM 'username' DB
            'password' => $credentials['password']
        ];

        // 3. Coba login menggunakan 'guard' admin
        if (Auth::guard('admin')->attempt($loginCredentials)) {
            $request->session()->regenerate();

            // 4. Jika berhasil, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'));
        }

        // 5. Jika gagal, kembali ke login admin dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.', // <-- MENGGUNAKAN KEY 'email' untuk error
        ])->onlyInput('email'); // <-- MENGGUNAKAN KEY 'email'
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
