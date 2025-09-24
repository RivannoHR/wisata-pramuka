<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class TouristAttraction extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'image_path',
        'location',
        'operating_hours',
        'is_active'
    ];

    protected $casts = [
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
        return match ($this->type) {
            'tourist_spot' => 'Tourist Spot',
            'restaurant' => 'Restaurant',
            'shop' => 'Shop',
            default => ucfirst($this->type)
        };
    }
    public function getImgCountAttribute()
    {
        return $this->images()->count();
    }

    /**
     * Relationship with ratings
     */
    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratable');
    }

    /**
     * Get the average rating for this attraction
     */
    public function getAverageRatingAttribute(): ?float
    {
        $average = $this->ratings()->avg('rating');
        return $average ? round($average, 1) : null;
    }

    /**
     * Get the total number of ratings
     */
    public function getRatingCountAttribute(): int
    {
        return $this->ratings()->count();
    }

    /**
     * Get the rating display (average or N/A)
     */
    public function getRatingDisplayAttribute(): string
    {
        $average = $this->getAverageRatingAttribute();
        return $average ? number_format($average, 1) : 'N/A';
    }

    /**
     * Check if user has rated this attraction
     */
    public function hasUserRated($userId): bool
    {
        return $this->ratings()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's rating for this attraction
     */
    public function getUserRating($userId): ?int
    {
        $rating = $this->ratings()->where('user_id', $userId)->first();
        return $rating ? $rating->rating : null;
    }
}
