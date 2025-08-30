<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_id',
        'title',
        'description',
        'price',
        'stock',
        'image_path',
        'is_active',
        'is_featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    /**
     * Boot method to auto-generate product_id
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->product_id)) {
                $product->product_id = self::generateProductId();
            }
        });
    }

    /**
     * Generate custom product ID in format PD00001
     */
    public static function generateProductId()
    {
        // Get the last product ID
        $lastProduct = self::orderBy('id', 'desc')->first();

        if (!$lastProduct || !$lastProduct->product_id) {
            // First product
            return 'PD00001';
        }

        // Extract number from last product_id (e.g., PD00001 -> 1)
        $lastNumber = (int) substr($lastProduct->product_id, 2);
        $nextNumber = $lastNumber + 1;

        // Format with leading zeros (5 digits total)
        return 'PD' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Get route key name for model binding (use product_id instead of id)
     */
    public function getRouteKeyName()
    {
        return 'product_id';
    }

    /**
     * Scope to filter only active products
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter featured products for carousel
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }
}
