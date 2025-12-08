<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product
use App\Models\Order;   // Import Model Order
use Illuminate\Support\Facades\Storage; // PENTING: Tambahkan ini untuk kelola file gambar

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Admin dengan Statistik dan Data.
     */
    public function index()
    {
        // 1. Ambil Data Statistik Ringkas
        $totalPendapatan = Order::where('status', 'paid')->sum('total_price');
        $totalOrder = Order::count();
        $totalMenu = Product::count();

        // 2. Ambil Data untuk Tab "Kelola Menu"
        $products = Product::all();

        // 3. Ambil Data untuk Tab "Riwayat Pesanan"
        $orders = Order::with(['user', 'items.product'])->latest()->get();

        return view('admin.dashboard', [
            'totalPendapatan' => $totalPendapatan,
            'totalOrder' => $totalOrder,
            'totalMenu' => $totalMenu,
            'products' => $products,
            'orders' => $orders
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
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        // Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // PERBAIKAN 1: Tambahkan 'public' sebagai parameter ke-3 agar masuk disk yang benar
            $file->storeAs('images/menu', $filename, 'public');

            // PERBAIKAN 2: Tambahkan 'storage/' agar path bisa dibaca browser
            $imagePath = 'storage/images/menu/' . $filename;
        }

        // Simpan ke Database
        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
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
            'category' => 'required|in:makanan,minuman',
            'price' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'description' => 'nullable|string'
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'description' => $request->description
        ];

        // Jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {

            // PERBAIKAN 3: Logika Hapus Gambar Lama yang lebih aman
            if ($product->image) {
                // Kita perlu menghapus prefix 'storage/' untuk mendapatkan path file asli di disk
                $oldPath = str_replace('storage/', '', $product->image);
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                }
            }

            // Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Simpan ke disk 'public'
            $file->storeAs('images/menu', $filename, 'public');

            // Simpan path dengan 'storage/'
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

        // PERBAIKAN 4: Logika Hapus Gambar saat Delete Menu
        if ($product->image) {
            // Hapus prefix 'storage/' agar path sesuai dengan struktur folder di disk public
            $relativePath = str_replace('storage/', '', $product->image);

            if (Storage::disk('public')->exists($relativePath)) {
                Storage::disk('public')->delete($relativePath);
            }
        }

        $product->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus!');
    }

    /**
     * Mengubah status order menjadi PAID secara manual.
     */
    public function markAsPaid($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'paid']);
        return back()->with('success', 'Status pesanan berhasil diubah menjadi Lunas (Paid).');
    }

    /**
     * Menampilkan halaman khusus cetak struk.
     */
    public function printReceipt($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.print_receipt', compact('order'));
    }
}
