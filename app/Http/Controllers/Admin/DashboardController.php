<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product
use App\Models\Order;   // Import Model Order

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Statistik Ringkas
        $totalPendapatan = Order::where('status', 'paid')->sum('total_price');
        $totalOrder = Order::count();
        $totalMenu = Product::count();

        // 2. Ambil Data untuk Tab "Kelola Menu"
        $products = Product::all();

        // 3. Ambil Data untuk Tab "Riwayat Pesanan" (Include detail item)
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        return view('admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalOrder' => $totalOrder,
            'totalMenu' => $totalMenu,
            'products' => $products,
            'orders' => $orders
        ]);
    }
}
