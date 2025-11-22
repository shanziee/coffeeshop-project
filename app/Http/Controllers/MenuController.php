<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk cek login
use App\Models\Product;
use App\Models\Order; // Penting untuk ambil data pesanan

class MenuController extends Controller
{
    /**
     * Menampilkan halaman menu utama.
     */
    public function showMenu()
    {
        // 1. AMBIL DATA PRODUK
        $menus = Product::all();

        // Format data produk agar siap pakai di frontend
        $formattedMenus = $menus->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'category' => $item->category,
                'description' => $item->description,
                // KEMBALI KE KODE ASLI ANDA: Tanpa 'storage/'
                'image' => asset($item->image),
            ];
        });

        // 2. AMBIL DATA RIWAYAT PESANAN (Fitur Baru)
        // Jika user login, ambil pesanan mereka. Jika tidak, kosong.
        $orders = Auth::check()
            ? Order::where('user_id', Auth::id())
                    ->with('items.product') // Load detail item & produk
                    ->latest() // Urutan terbaru diatas
                    ->get()
            : collect();

        // 3. KIRIM KE VIEW
        return view('menu', [
            'menus' => $formattedMenus,
            'orders' => $orders
        ]);
    }
}
