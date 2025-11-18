<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;       // <-- Import Model Order
use App\Models\OrderItem;   // <-- Import Model OrderItem
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB; // Untuk database transaction

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Gunakan DB Transaction agar jika error di tengah jalan, data tidak tersimpan setengah-setengah
        return DB::transaction(function () use ($request) {

            // 1. Buat Nomor Order Unik
            // Format: ORDER-{ID_USER}-{TIMESTAMP_ACAK}
            $orderNumber = 'ORDER-' . auth()->id() . '-' . time();

            // 2. Simpan Data Utama ke Tabel 'orders'
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'total_price' => $request->total_price,
                'status' => 'unpaid', // Status awal belum bayar
            ]);

            // 3. Simpan Detail Item ke Tabel 'order_items'
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'], // Pastikan frontend kirim 'id' produk
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    // Ambil sugar level dari nama item (cara cepat) atau kirim field terpisah dari frontend
                    // Di frontend Anda mengirim: "Kopi (50%)", kita simpan stringnya saja dulu
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
                    'order_id' => $orderNumber, // Gunakan order_number kita
                    'gross_amount' => (int) $request->total_price, // Midtrans butuh integer
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
            ];

            // 6. Minta Snap Token
            try {
                $snapToken = Snap::getSnapToken($params);

                // Update snap_token ke database agar bisa dipakai ulang jika perlu
                $order->update(['snap_token' => $snapToken]);

                // Kembalikan Snap Token dan Order ID ke Frontend
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
