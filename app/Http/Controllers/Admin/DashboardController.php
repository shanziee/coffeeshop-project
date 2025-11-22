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
            'category' => 'required|in:makanan,minuman', // Sesuaikan dengan enum di database
            'price' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Wajib upload gambar
            'description' => 'nullable|string'
        ]);

        // Proses Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            // Nama file unik: waktu_nama-asli
            $filename = time() . '_' . $file->getClientOriginalName();
            // Simpan ke folder 'public/images/menu'
            $file->storeAs('public/images/menu', $filename);
            // Path yang disimpan ke database (sesuai cara pemanggilan di view)
            $imagePath = 'images/menu/' . $filename;
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

        // Validasi (image jadi nullable/opsional karena mungkin tidak diganti)
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
            // 1. Hapus gambar lama jika ada
            if ($product->image && Storage::exists('public/' . $product->image)) {
                Storage::delete('public/' . $product->image);
            } elseif ($product->image && file_exists(public_path($product->image))) {
                 // Fallback jika gambar ada di folder public biasa (bukan symlink storage)
                 @unlink(public_path($product->image));
            }

            // 2. Upload gambar baru
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/images/menu', $filename);
            $data['image'] = 'images/menu/' . $filename;
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

        // Hapus file gambar terkait dari storage agar tidak menumpuk
        if ($product->image && Storage::exists('public/' . $product->image)) {
            Storage::delete('public/' . $product->image);
        } elseif ($product->image && file_exists(public_path($product->image))) {
             @unlink(public_path($product->image));
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
