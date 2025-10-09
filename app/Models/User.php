<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'phone',
        'address',
        'is_admin',
        'email_otp',
        'email_otp_expires_at',
        'is_verified',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'email_otp_expires_at' => 'datetime',
        'is_admin' => 'boolean',
        'is_verified' => 'boolean',
    ];

    /**
     * Check if the user is an administrator
     */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    /**
     * Scope to filter only admin users
     */
    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true);
    }

    /**
     * Scope to filter only regular users
     */
    public function scopeRegularUsers($query)
    {
        return $query->where('is_admin', false);
    }

    /**
     * Get the bookings for the user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the reviews written by the user
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the article comments written by the user
     */
    public function articleComments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    /**
     * Get the ratings given by the user
     */
    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Generate and save OTP for email verification
     */
    public function generateEmailOTP()
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $this->update([
            'email_otp' => $otp,
            'email_otp_expires_at' => now()->addMinutes(10), // OTP expires in 10 minutes
        ]);
        return $otp;
    }

    /**
     * Verify the provided OTP
     */
    public function verifyEmailOTP($otp)
    {
        if ($this->email_otp === $otp && $this->email_otp_expires_at > now()) {
            $this->update([
                'email_otp' => null,
                'email_otp_expires_at' => null,
                'email_verified_at' => now(),
                'is_verified' => true,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Check if OTP has expired
     */
    public function isOTPExpired()
    {
        return $this->email_otp_expires_at && $this->email_otp_expires_at < now();
    }

    /**
     * Check if user is fully verified
     */
    public function isFullyVerified()
    {
        return $this->is_verified && $this->email_verified_at;
    }
}