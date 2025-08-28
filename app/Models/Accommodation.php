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

    public function getMainImageAttribute(): string
    {
        $featuredImage = $this->featuredImage;
        if ($featuredImage) {
            return asset('storage/' . $featuredImage->image_path);
        }

        // If no featured image, get the first image by sort order
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return asset('storage/' . $firstImage->image_path);
        }

        // Fallback to old image_path field if it exists
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

    public function getFormattedPriceAttribute(): string
    {
        if ($this->price_per_night) {
            return 'Rp ' . number_format($this->price_per_night, 0, ',', '.') . '/night';
        }
        return 'Contact for pricing';
    }

    public function getCapacityDisplayAttribute(): string
    {
        return $this->capacity . '-' . ($this->capacity + 2);
    }

    public function images()
    {
        return $this->hasMany(AccommodationImage::class)->orderBy('sort_order');
    }

    public function featuredImage()
    {
        return $this->hasOne(AccommodationImage::class)->where('is_featured', true);
    }

    public function getFirstImageAttribute(): string
    {
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return asset('storage/' . $firstImage->image_path);
        }

        return $this->getMainImageAttribute();
    }
    public function roomTypes()
    {
        return $this->hasMany(AccommodationRoomType::class);
    }
    public function getLowestPriceAttribute(): string
    {

        return number_format($this->roomTypes()->min('price'));
    }
    public function getImgCountAttribute()
    {
        return $this->images()->count();
    }
}
