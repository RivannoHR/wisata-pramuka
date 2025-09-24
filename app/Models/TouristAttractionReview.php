<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TouristAttractionReview extends Model
{
    protected $fillable = [
        'tourist_attraction_id',
        'user_id',
        'rating',
        'comment',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the tourist attraction that this review belongs to
     */
    public function touristAttraction()
    {
        return $this->belongsTo(TouristAttraction::class);
    }

    /**
     * Get the user who wrote this review
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
        return $stars . " ({$this->rating}/5)";
    }

    /**
     * Get star rating as HTML
     */
    public function getStarRatingHtmlAttribute(): string
    {
        $html = '';
        for ($i = 1; $i <= 5; $i++) {
            if ($i <= $this->rating) {
                $html .= '<i class="fas fa-star"></i>';
            } else {
                $html .= '<i class="far fa-star"></i>';
            }
        }
        return $html;
    }
}
