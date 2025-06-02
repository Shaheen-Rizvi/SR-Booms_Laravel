<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Order extends Model
{

    use HasFactory;
    protected $fillable = [
    'user_id',      // Customer who placed the order
    'total_amount', 
    'status',       // "Pending", "Delivered", etc.
    'delivery_date',
];

// An order belongs to a customer (user)
public function user() {
    return $this->belongsTo(User::class);
}

// An order contains many flowers via order items
public function orderItems() {
    return $this->hasMany(OrderItem::class);
}


public function getTotalAttribute() {
    return $this->orderItems->sum(function ($item) {
        return $item->quantity * $item->unit_price;
    });
}

}
