<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel untuk menyimpan data utama pesanan
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menyimpan ID User yang memesan
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // ID Unik untuk Midtrans (misal: ORDER-12345)
            $table->string('order_number')->unique();

            $table->decimal('total_price', 10, 2);

            // Status pembayaran: unpad (pending), paid (sukses), failed (gagal/expire)
            $table->enum('status', ['unpaid', 'paid', 'failed', 'cancelled'])->default('unpaid');

            // Menyimpan Snap Token jaga-jaga jika user menutup popup dan ingin bayar nanti
            $table->string('snap_token')->nullable();

            $table->timestamps();
        });

        // 2. Tabel untuk menyimpan detail item per pesanan
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relasi ke tabel products
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Harga saat transaksi (penting jika harga menu berubah nanti)
            $table->string('sugar_level')->nullable(); // Menyimpan catatan gula (0%, 50%, dll)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
