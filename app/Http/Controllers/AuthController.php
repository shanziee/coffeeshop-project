<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // <-- IMPORT MODEL USER
use Illuminate\Support\Facades\Hash; // <-- IMPORT HASH UNTUK PASSWORD
use Illuminate\Support\Facades\Auth; // <-- IMPORT AUTH UNTUK LOGIN

class AuthController extends Controller
{
    // Menampilkan halaman login (resources/views/login.blade.php)
    public function showLogin()
    {
        return view('login');
    }

    // Menampilkan halaman register (resources/views/register.blade.php)
    public function showRegister()
    {
        return view('register');
    }

    /**
     * FUNGSI BARU: Memproses data dari form registrasi
     */
    public function registerProcess(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed', // 'confirmed' akan otomatis mencocokkan dengan 'password_confirmation'
        ]);

        // 2. Buat user baru di database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
        ]);

        // 3. Arahkan ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    /**
     * FUNGSI BARU: Memproses data dari form login
     */
    public function loginProcess(Request $request)
    {
        // 1. Validasi data
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Coba untuk login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Jika BERHASIL, arahkan ke halaman menu
            return redirect()->intended(route('menu'));
        }

        // 4. Jika GAGAL, kembali ke login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    /**
     * FUNGSI BARU: Memproses logout
     */
    public function logout(Request $request)
    {
        Auth::logout(); // Logout user

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/'); // Kembali ke halaman menu
    }
}
