<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product
use App\Models\Order;   // Import Model Order

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Admin dengan Statistik dan Data.
     */
    public function index()
    {
        // 1. Ambil Data Statistik Ringkas
        // Hitung total pendapatan hanya dari pesanan yang sudah lunas (paid)
        $totalPendapatan = Order::where('status', 'paid')->sum('total_price');

        // Hitung jumlah total pesanan
        $totalOrder = Order::count();

        // Hitung jumlah menu yang tersedia
        $totalMenu = Product::count();

        // 2. Ambil Data untuk Tab "Kelola Menu"
        // Mengambil semua produk untuk ditampilkan di tabel manajemen menu
        $products = Product::all();

        // 3. Ambil Data untuk Tab "Riwayat Pesanan"
        // Mengambil pesanan terbaru beserta relasi user dan detail itemnya (Eager Loading)
        // 'items.product' digunakan untuk mendapatkan nama produk di setiap item pesanan
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        // Kirim semua data ke view 'admin.dashboard'
        return view('admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalOrder' => $totalOrder,
            'totalMenu' => $totalMenu,
            'products' => $products,
            'orders' => $orders
        ]);
    }

    /**
     * Mengubah status order menjadi PAID secara manual.
     * Digunakan jika pembayaran dilakukan secara tunai atau manual di luar sistem otomatis.
     */
    public function markAsPaid($id)
    {
        // Cari order berdasarkan ID, jika tidak ada akan error 404
        $order = Order::findOrFail($id);

        // Update status menjadi 'paid'
        $order->update(['status' => 'paid']);

        // Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Status pesanan berhasil diubah menjadi Lunas (Paid).');
    }

    /**
     * Menampilkan halaman khusus cetak struk (Thermal Printer Friendly).
     * Halaman ini didesain minimalis untuk printer kasir.
     */
    public function printReceipt($id)
    {
        // Ambil order beserta item dan detail produknya untuk dicetak
        $order = Order::with('items.product')->findOrFail($id);

        // Tampilkan view 'admin.print_receipt'
        return view('admin.print_receipt', compact('order'));
    }
}
