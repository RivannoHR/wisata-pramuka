<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TouristAttraction extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'image_path',
        'location',
        'rating',
        'operating_hours',
        'is_active'
    ];

    protected $casts = [
        'rating' => 'decimal:1',
        'operating_hours' => 'array',
        'is_active' => 'boolean'
    ];

    /**
     * Get the images for the tourist attraction
     */
    public function images(): HasMany
    {
        return $this->hasMany(TouristAttractionImage::class)->ordered();
    }

    /**
     * Get the featured image for the tourist attraction
     */
    public function featuredImage()
    {
        return $this->hasOne(TouristAttractionImage::class)->featured()->ordered();
    }

    /**
     * Get the main image (featured image or first image or fallback)
     */
    public function getMainImageAttribute(): string
    {
        // Try to get featured image first
        $featuredImage = $this->featuredImage;
        if ($featuredImage) {
            return $featuredImage->image_url;
        }

        // Try to get first image
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }

        // Fallback to single image_path if exists
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

        // Default fallback image
        return asset('/images/destinations/default-attraction.jpg');
    }

    /**
     * Scope to filter only active attractions
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
        return match($this->type) {
            'tourist_spot' => 'Tourist Spot',
            'restaurant' => 'Restaurant',
            'shop' => 'Shop',
            default => ucfirst($this->type)
        };
    }
}
