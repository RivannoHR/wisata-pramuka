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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
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
}