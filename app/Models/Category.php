<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use HasFactory,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',   // e.g., "Roses", "Wedding Bouquets"
        'color',  // e.g., "#FF9EB5" (for UI display)
    ];

    /**
     * Get all flowers belonging to this category.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<Flower>
     */
    public function flowers(): HasMany
    {
        return $this->hasMany(Flower::class);
    }

    /**
     * Scope for active categories (optional)
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Accessor for formatted color (optional)
     */
    public function getFormattedColorAttribute(): string
    {
        return strtoupper($this->color);
    }
}