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

    public function images(): HasMany
    {
        return $this->hasMany(TouristAttractionImage::class)->ordered();
    }

    public function featuredImage()
    {
        return $this->hasOne(TouristAttractionImage::class)->featured()->ordered();
    }

    public function getMainImageAttribute(): string
    {
        $featuredImage = $this->featuredImage;
        if ($featuredImage) {
            return $featuredImage->image_url;
        }

        $firstImage = $this->images()->first();
        if ($firstImage) {
            return $firstImage->image_url;
        }

        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }

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
