<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat User Dummy (bawaan)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // TAMBAHKAN BARIS INI:
        // Memanggil seeder untuk Admin dan Produk
        $this->call([
            AdminSeeder::class,   // Agar akun admin juga dibuat
            ProductSeeder::class, // Agar menu masuk ke database
        ]);
    }
}
