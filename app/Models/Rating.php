<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Rating extends Model
{
    protected $fillable = [
        'user_id',
        'ratable_type',
        'ratable_id',
        'rating',
        'comment'
    ];

    protected $casts = [
        'rating' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ratable(): MorphTo
    {
        return $this->morphTo();
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
