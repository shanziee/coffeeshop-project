<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'sugar_level',
    ];

    // Relasi: Item milik Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: Item adalah sebuah Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
