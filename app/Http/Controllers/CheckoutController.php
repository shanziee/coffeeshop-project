<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;     // <-- TAMBAHKAN INI: Import Model Product
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Gunakan DB Transaction agar jika error (stok habis), data tidak tersimpan setengah-setengah
        return DB::transaction(function () use ($request) {

            // 1. Buat Nomor Order Unik
            $orderNumber = 'ORDER-' . auth()->id() . '-' . time();

            // 2. Simpan Data Utama ke Tabel 'orders'
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'total_price' => $request->total_price,
                'status' => 'unpaid',
            ]);

            // 3. Simpan Detail Item & Kurangi Stok
            foreach ($request->items as $item) {
                // Cari produk berdasarkan ID
                $product = Product::findOrFail($item['id']);

                // Validasi: Cek apakah stok mencukupi
                if ($product->stock < $item['quantity']) {
                    // Jika stok kurang, lempar error agar transaksi dibatalkan (rollback)
                    throw new \Exception("Stok untuk produk {$product->name} tidak mencukupi.");
                }

                // KURANGI STOK PRODUK
                $product->decrement('stock', $item['quantity']);

                // Simpan ke detail item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'sugar_level' => isset($item['name']) && strpos($item['name'], '(') !== false
                                    ? trim(substr($item['name'], strpos($item['name'], '(')))
                                    : null,
                ]);
            }

            // 4. Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // 5. Siapkan Parameter untuk Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => (int) $request->total_price,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
            ];

            // 6. Minta Snap Token
            try {
                $snapToken = Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);

                return response()->json([
                    'snap_token' => $snapToken,
                    'order_id' => $orderNumber
                ]);

            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }
        });
    }
}
