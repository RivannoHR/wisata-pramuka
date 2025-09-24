<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_id',
        'user_id',
        'accommodation_id',
        'rooms_count',
        'booking_date',
        'check_in_date',
        'check_out_date',
        'duration_days',
        'total_price',
        'status',
        'special_requests',
        'notes'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'checkin_date' => 'date',
        'checkout_date' => 'date',
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
        'rooms_count' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'active' => 'success',
            'completed' => 'info',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get status display name
     */
    public function getStatusDisplayAttribute(): string
    {
        return ucfirst($this->status);
    }

    /**
     * Scope for filtering by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for user's bookings
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute(): string
    {
        $days = $this->duration_days ?? 1;
        return $days . ' ' . ($days == 1 ? 'day' : 'days');
    }

    /**
     * Get formatted date range
     */
    public function getFormattedDateRangeAttribute(): string
    {
        if ($this->check_in_date && $this->check_out_date) {
            return $this->check_in_date->format('M d') . ' - ' . $this->check_out_date->format('M d, Y');
        }
        return $this->booking_date->format('M d, Y');
    }

    /**
     * Check if booking can be reviewed
     */
    public function canBeReviewed(): bool
    {
        return $this->status === 'completed' && !$this->review;
    }

    /**
     * Check if booking has been reviewed
     */
    public function hasReview(): bool
    {
        return $this->review !== null;
    }

    /**
     * Check if booking is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
