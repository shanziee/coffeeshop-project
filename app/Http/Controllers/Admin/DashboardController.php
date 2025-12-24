<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Ambil Data Statistik Ringkas
        $totalPendapatan = Order::where('status', 'paid')->sum('total_price');
        $totalOrder = Order::count();
        $totalMenu = Product::count();

        // 2. Statistik Grafik (MySQL Compatible)
        // Jika error SQL muncul di sini, pastikan database Anda MySQL/MariaDB, bukan SQLite.

        // Rekap Harian
        $dailyStats = Order::selectRaw('DATE(created_at) as date, COUNT(*) as total_orders, SUM(total_price) as revenue')
            ->where('status', 'paid')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();

        // Rekap Bulanan
        $monthlyStats = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as total_orders, SUM(total_price) as revenue')
            ->where('status', 'paid')
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Rekap Tahunan
        $yearlyStats = Order::selectRaw('YEAR(created_at) as year, COUNT(*) as total_orders, SUM(total_price) as revenue')
            ->where('status', 'paid')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // 3. Ambil Data Produk & Order
        $products = Product::all();
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        return view('admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalOrder' => $totalOrder,
            'totalMenu' => $totalMenu,
            'products' => $products,
            'orders' => $orders,
            'dailyStats' => $dailyStats,
            'monthlyStats' => $monthlyStats,
            'yearlyStats' => $yearlyStats
        ]);
    }

    /**
     * MENYIMPAN MENU BARU (CREATE)
     */
    public function storeMenu(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            // PERBAIKAN: Snack sudah ditambahkan di sini
            'category' => 'required|in:minuman,makanan,snack',
            'price' => 'required|integer',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        // Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/menu', $filename, 'public');
            $imagePath = 'storage/images/menu/' . $filename;
        }

        // Simpan ke Database
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Menu baru berhasil ditambahkan!');
    }

    /**
     * MENGUPDATE MENU (UPDATE)
     */
    public function updateMenu(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // PERBAIKAN: Snack sudah ditambahkan di sini
            'category' => 'required|in:minuman,makanan,snack',
            'price' => 'required|integer',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description
        ];

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama
            if ($product->image) {
                $oldPath = str_replace('storage/', '', $product->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
            // Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('images/menu', $filename, 'public');
            $data['image'] = 'storage/images/menu/' . $filename;
        }

        $product->update($data);

        return redirect()->back()->with('success', 'Menu berhasil diperbarui!');
    }

    /**
     * MENGHAPUS MENU (DELETE)
     */
    public function destroyMenu($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image) {
            $relativePath = str_replace('storage/', '', $product->image);
            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $product->delete();
        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    public function markAsPaid($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'paid']);
        return back()->with('success', 'Status pesanan berhasil diubah menjadi Lunas (Paid).');
    }

    public function printReceipt($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.print_receipt', compact('order'));
    }
}
