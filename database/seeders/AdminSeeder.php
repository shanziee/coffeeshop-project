<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; // Pastikan Anda mengimpor model Admin
use Illuminate\Support\Facades\Hash; // Penting untuk enkripsi password

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kode ini yang membuat 1 pengguna di tabel 'admins'
        Admin::create([
            'username' => 'admin',
            'password' => Hash::make('12345678') // Ganti dengan password Anda
        ]);
    }
}
