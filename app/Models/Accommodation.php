<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'location',
        'rating',
        'capacity',
        'facilities',
        'image_path',
        'price_per_night',
        'is_active'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'capacity' => 'integer',
        'facilities' => 'array',
        'price_per_night' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Scope to filter only active accommodations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get formatted type name
     */
    public function getFormattedTypeAttribute()
    {
        return ucfirst($this->type);
    }

    /**
     * Get main image URL
     */
    public function getMainImageAttribute(): string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        
        // Use local placeholder images based on type
        $placeholders = [
            'hotel' => '/images/accommodations/placeholder-hotel.jpg',
            'resort' => '/images/accommodations/placeholder-resort.jpg',
            'villa' => '/images/accommodations/placeholder-villa.jpg',
            'homestay' => '/images/accommodations/placeholder-homestay.jpg',
            'guesthouse' => '/images/accommodations/placeholder-guesthouse.jpg'
        ];
        
        return asset($placeholders[$this->type] ?? $placeholders['hotel']);
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_per_night) {
            return 'Rp ' . number_format($this->price_per_night, 0, ',', '.') . '/night';
        }
        return 'Contact for pricing';
    }

    /**
     * Get capacity display
     */
    public function getCapacityDisplayAttribute(): string
    {
        return $this->capacity . '-' . ($this->capacity + 2);
    }
}
