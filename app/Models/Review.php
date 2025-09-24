<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the booking that this review belongs to
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the user who wrote this review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the accommodation through the booking
     */
    public function accommodation()
    {
        return $this->hasOneThrough(Accommodation::class, Booking::class, 'id', 'id', 'booking_id', 'accommodation_id');
    }

    /**
     * Get formatted rating with stars
     */
    public function getFormattedRatingAttribute(): string
    {
        if (!$this->rating) {
            return 'No rating';
        }
        
        $stars = str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
        return $stars . ' (' . $this->rating . '/5)';
    }

    /**
     * Check if review has rating
     */
    public function hasRating(): bool
    {
        return !is_null($this->rating) && $this->rating > 0;
    }

    /**
     * Check if review has comment
     */
    public function hasComment(): bool
    {
        return !empty(trim($this->comment));
    }

    /**
     * Scope for reviews with ratings
     */
    public function scopeWithRating($query)
    {
        return $query->whereNotNull('rating')->where('rating', '>', 0);
    }

    /**
     * Scope for reviews with comments
     */
    public function scopeWithComment($query)
    {
        return $query->whereNotNull('comment')->where('comment', '!=', '');
    }
}
