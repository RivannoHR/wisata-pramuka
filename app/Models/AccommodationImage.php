<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationImage extends Model
{
    protected $fillable = [
        'accommodation_id',
        'image_path',
        'alt_text',
        'sort_order',
        'is_featured'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
