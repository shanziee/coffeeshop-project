<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // 1. Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 2. Buat Data Transaksi
        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . rand(),
                'gross_amount' => $request->total_price,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            // Data Item (Opsional, agar muncul di list Midtrans)
            'item_details' => $request->items,
        ];

        // 3. Minta Snap Token dari Midtrans
        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
