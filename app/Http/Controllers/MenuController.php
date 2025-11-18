<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // <-- Import Model Product

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu utama.
     */
    public function showMenu()
    {
        // Ambil semua data produk dari database
        $menus = Product::all();

        // Kita perlu memodifikasi URL gambar agar menggunakan asset() helper
        // Namun karena kita akan kirim ke JS, kita bisa lakukan di map atau biarkan view menangani pathnya.
        // Untuk amannya, kita format sedikit agar siap pakai di frontend.
        $formattedMenus = $menus->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'category' => $item->category,
                'description' => $item->description,
                'image' => asset($item->image), // Generate URL lengkap
            ];
        });

        // Kirim data $formattedMenus ke view dengan nama variabel 'menus'
        return view('menu', ['menus' => $formattedMenus]);
    }
}
