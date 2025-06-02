<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flower extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',           // e.g., "Red Roses Bouquet"
        'description',    // Floral arrangement details
        'price',          // e.g., 29.99
        'color',          // Primary color (e.g., "Red")
        'category_id',    // Links to Category
        'stock_quantity', // Available inventory
        'image_url',      // URL for flower image
    ];

    /**
     * Get the category that owns the flower.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the flower.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    
}