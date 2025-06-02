<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = [
    'order_id',
    'flower_id',
    'quantity',    // e.g., 2 (bouquets)
    'unit_price',  // Price per item at time of purchase
];

// An order item belongs to an order
public function order() {
    return $this->belongsTo(Order::class);
}


public function flower() {
    return $this->belongsTo(Flower::class);
}
}
