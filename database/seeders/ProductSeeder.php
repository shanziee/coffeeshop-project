<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Caffe Latte',
                'price' => 28000,
                'category' => 'minuman',
                'description' => 'Espresso dengan susu segar yang lembut.',
                'image' => 'images/menu/cafe-latte.png'
            ],
            [
                'name' => 'Matcha Latte',
                'price' => 26000,
                'category' => 'minuman',
                'description' => 'Bubuk matcha Jepang asli dengan susu.',
                'image' => 'images/menu/Matcha-Lattee.png'
            ],
            [
                'name' => 'Signature Americano',
                'price' => 22000,
                'category' => 'minuman',
                'description' => 'Espresso shot ganda dengan air panas.',
                'image' => 'images/menu/Signature-Americano.png'
            ],
            [
                'name' => 'Signature Chocolate',
                'price' => 28000,
                'category' => 'minuman',
                'description' => 'Cokelat premium Belgia yang kaya rasa.',
                'image' => 'images/menu/signature-chocolate.png'
            ],
            [
                'name' => 'Espresso',
                'price' => 18000,
                'category' => 'minuman',
                'description' => 'Ekstrak kopi murni yang kuat dan nikmat.',
                'image' => 'images/menu/espresso.png'
            ],
            [
                'name' => 'Kopi Tubruk',
                'price' => 20000,
                'category' => 'minuman',
                'description' => 'Kopi hitam tradisional dengan ampas.',
                'image' => 'images/menu/kopi-tubruk.png'
            ],
            [
                'name' => 'Butter Croissant',
                'price' => 22000,
                'category' => 'makanan',
                'description' => 'Pastry renyah dengan mentega Prancis.',
                'image' => 'images/menu/butter-croissant.png'
            ],
            [
                'name' => 'Choco Chip Cookies',
                'price' => 15000,
                'category' => 'makanan',
                'description' => 'Kue kering manis dengan butiran cokelat.',
                'image' => 'images/menu/choco-chip-cookies.png'
            ],
            [
                'name' => 'Tuna Sandwich',
                'price' => 30000,
                'category' => 'makanan',
                'description' => 'Roti lapis isi tuna dan sayuran segar.',
                'image' => 'images/menu/tuna-sandwich.png'
            ],
            [
                'name' => 'Red Velvet Cake',
                'price' => 32000,
                'category' => 'makanan',
                'description' => 'Kue lembut dengan krim keju yang manis.',
                'image' => 'images/menu/red-velvet-cake.png'
            ],
            [
                'name' => 'Kentang Goreng',
                'price' => 20000,
                'category' => 'makanan',
                'description' => 'Kentang goreng renyah bumbu spesial.',
                'image' => 'images/menu/kentang-goreng.png'
            ],
            [
                'name' => 'Banana Bread',
                'price' => 25000,
                'category' => 'makanan',
                'description' => 'Roti pisang lembut, manis alami.',
                'image' => 'images/menu/banana-bread.png'
            ],
        ];

        foreach ($menus as $menu) {
            Product::create($menu);
        }
    }
}
