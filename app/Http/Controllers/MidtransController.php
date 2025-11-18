<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\Log; // Untuk logging debug

class MidtransController extends Controller
{
    /**
     * Endpoint untuk menerima notifikasi callback dari Midtrans.
     */
    public function callback(Request $request)
    {
        // 1. Set konfigurasi Midtrans
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');

        // Log request yang masuk untuk debugging
        Log::info('Midtrans Callback Received', $request->all());

        try {
            // Midtrans SDK otomatis memverifikasi signature hash dengan Server Key
            $notif = new Notification();
        } catch (\Exception $e) {
            // Jika verifikasi hash gagal atau ada error di SDK, tolak notifikasi
            Log::error('Midtrans Notification Error', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Notifikasi tidak valid'], 404);
        }

        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $orderId = $notif->order_id;
        $fraudStatus = $notif->fraud_status;

        // Cari order di database lokal
        $order = Order::where('order_number', $orderId)->first();

        if (!$order) {
            Log::warning('Order ID Not Found', ['order_id' => $orderId]);
            return response()->json(['message' => 'Order ID tidak ditemukan.'], 404);
        }

        // Cek jika status lokal sudah "paid", hindari update duplikasi
        if ($order->status == 'paid') {
            return response()->json(['message' => 'Status sudah PAID.'], 200);
        }

        $newStatus = $order->status;

        // 3. Logika Update Status Berdasarkan Midtrans Transaction Status
        if ($transaction == 'capture') {
            // Capture (hanya untuk credit card/cimb clicks)
            if ($type == 'credit_card' && $fraudStatus == 'challenge') {
                $newStatus = 'pending';
            } elseif ($fraudStatus == 'accept') {
                $newStatus = 'paid';
            }
        } elseif ($transaction == 'settlement') {
            // Pembayaran non-kartu kredit berhasil
            $newStatus = 'paid';
        } elseif ($transaction == 'pending') {
            // Menunggu pembayaran
            $newStatus = 'unpaid';
        } elseif ($transaction == 'deny' || $transaction == 'expire') {
            // Pembayaran ditolak atau batas waktu habis
            $newStatus = 'failed';
        } elseif ($transaction == 'cancel') {
            // Pembayaran dibatalkan
            $newStatus = 'cancelled';
        }

        // Update status di database lokal
        if ($newStatus != $order->status) {
            $order->update(['status' => $newStatus]);
            Log::info("Order ID {$orderId} status updated to: {$newStatus}");
        }

        // Kembalikan response 200 OK ke Midtrans
        return response()->json(['message' => 'Notifikasi sukses diproses'], 200);
    }
}
