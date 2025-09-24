<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Accommodation extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'location',
        'capacity',
        'price',
        'facilities',
        'is_active'
    ];

    protected $casts = [
        'capacity' => 'integer',
        'price' => 'decimal:2',
        'facilities' => 'array',
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
        if ($this->price) {
            return 'Rp ' . number_format($this->price, 0, ',', '.') . '/night';
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

    public function scopebyprice($query) {}

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
     * Get the average rating for this accommodation (combining direct ratings and review ratings)
     */
    public function getAverageRatingAttribute(): ?float
    {
        // Get average from direct ratings (Rating model)
        $directRatingsAvg = $this->ratings()->avg('rating');
        $directRatingsCount = $this->ratings()->count();
        
        // Get average from reviews (Review model through bookings)
        $reviewsAvg = $this->reviews()->avg('rating');
        $reviewsCount = $this->reviews()->count();
        
        // If we have both, calculate weighted average
        if ($directRatingsCount > 0 && $reviewsCount > 0) {
            $totalRatings = ($directRatingsAvg * $directRatingsCount) + ($reviewsAvg * $reviewsCount);
            $totalCount = $directRatingsCount + $reviewsCount;
            return round($totalRatings / $totalCount, 1);
        }
        
        // If only direct ratings exist
        if ($directRatingsCount > 0) {
            return round($directRatingsAvg, 1);
        }
        
        // If only review ratings exist
        if ($reviewsCount > 0) {
            return round($reviewsAvg, 1);
        }
        
        // No ratings at all
        return null;
    }

    /**
     * Get the total number of ratings (combining direct ratings and review ratings)
     */
    public function getRatingCountAttribute(): int
    {
        $directRatingsCount = $this->ratings()->count();
        $reviewsCount = $this->reviews()->count();
        return $directRatingsCount + $reviewsCount;
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
     * Check if user has rated this accommodation
     */
    public function hasUserRated($userId): bool
    {
        return $this->ratings()->where('user_id', $userId)->exists();
    }

    /**
     * Get user's rating for this accommodation
     */
    public function getUserRating($userId): ?int
    {
        $rating = $this->ratings()->where('user_id', $userId)->first();
        return $rating ? $rating->rating : null;
    }

    /**
     * Get reviews from completed bookings for this accommodation
     */
    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,
            Booking::class,
            'accommodation_id', // Foreign key on bookings table
            'booking_id',       // Foreign key on reviews table
            'id',              // Local key on accommodations table
            'id'               // Local key on bookings table
        )->whereHas('booking', function($query) {
            $query->where('status', 'completed');
        });
    }

    /**
     * Get the average rating from reviews (overrides the existing method)
     */
    public function getAverageRatingFromReviewsAttribute(): ?float
    {
        $average = $this->reviews()->avg('rating');
        return $average ? round($average, 1) : null;
    }

    /**
     * Get the total number of reviews from completed bookings
     */
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Get the review rating display (average or N/A)
     */
    public function getReviewRatingDisplayAttribute(): string
    {
        $average = $this->getAverageRatingFromReviewsAttribute();
        return $average ? number_format($average, 1) : 'N/A';
    }
}
