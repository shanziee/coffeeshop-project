<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // KODE INI YANG MEMBUAT 1 PENGGUNA DI TABEL 'ADMINS'
        Admin::create([
            'username' => 'admin@gmail.com', // <-- DIUBAH MENJADI EMAIL
            'password' => Hash::make('12345678')
        ]);
    }
}
