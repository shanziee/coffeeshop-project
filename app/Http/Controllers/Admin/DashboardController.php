<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;   // Import Model Order
use App\Models\Product; // Import Model Product
use Carbon\Carbon;      // Import Carbon untuk tanggal

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Pesanan Baru (Pesanan yang masuk hari ini)
        $todaysOrders = Order::whereDate('created_at', Carbon::today())->count();

        // 2. Hitung Total Menu Aktif
        $totalMenus = Product::count();

        // 3. Hitung Pendapatan Hari Ini (Hanya yang statusnya 'paid')
        // Catatan: Karena belum ada callback Midtrans (Langkah 4), nilai ini mungkin masih 0 jika semua status 'unpaid'.
        $todaysRevenue = Order::whereDate('created_at', Carbon::today())
            ->where('status', 'paid')
            ->sum('total_price');

        // 4. Ambil 5 Pesanan Terbaru untuk Tabel
        $recentOrders = Order::with('user') // Eager load relasi user agar hemat query
            ->latest()
            ->take(5)
            ->get();

        // Kirim semua data ke view
        return view('admin.dashboard', compact(
            'todaysOrders',
            'totalMenus',
            'todaysRevenue',
            'recentOrders'
        ));
    }
}
