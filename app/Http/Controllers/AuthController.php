<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin; // Import Model Admin

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
     * FUNGSI MODIFIKASI: Memproses login untuk Customer ATAU Admin.
     */
    public function loginProcess(Request $request)
    {
        // 1. Validasi data (wajib menggunakan key 'email')
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // --- COBA LOGIN SEBAGAI CUSTOMER (GUARD 'WEB') ---
        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            // Berhasil login sebagai Customer, arahkan ke menu
            return redirect()->intended(route('menu'));
        }

        // --- JIKA GAGAL, COBA LOGIN SEBAGAI ADMIN (GUARD 'ADMIN') ---

        // Catatan: Admin menggunakan kolom 'username' di DB, namun kita treat sebagai email.
        $adminCredentials = [
            'username' => $credentials['email'], // Meneruskan input 'email' ke kolom 'username' admin DB
            'password' => $credentials['password'],
        ];

        if (Auth::guard('admin')->attempt($adminCredentials, $request->has('remember'))) {
            $request->session()->regenerate();

            // Berhasil login sebagai Admin, arahkan ke dashboard
            return redirect()->intended(route('admin.dashboard'));
        }

        // --- JIKA KEDUANYA GAGAL ---
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
