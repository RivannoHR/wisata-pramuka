<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'product_id',
        'title',
        'description',
        'image_path',
        'order',
        'stock',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'stock' => 'integer',
        'order' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-generate product_id when creating a new product
        static::creating(function ($product) {
            if (empty($product->product_id)) {
                $product->product_id = static::generateProductId();
            }
        });
    }

    // Generate Product ID
    private static function generateProductId()
    {
        $lastProduct = static::orderBy('id', 'desc')->first();
        
        if ($lastProduct) {
            // Extract number from last product_id (e.g., PD000001 -> 1)
            $lastNumber = (int) substr($lastProduct->product_id, 2);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        // Format as PD000001
        return 'PD' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    // Cek apakah produk ada
    public function isInStock()
    {
        return $this->stock > 0;
    }

    // Kurangi stock
    public function reduceStock($quantity)
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    // Nambah stock
    public function addStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();
    }
}
