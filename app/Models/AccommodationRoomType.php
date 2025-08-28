<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccommodationRoomType extends Model
{
    protected $fillable = [
        'accommodation_id',
        'name',
        'image_path',
        'price'
    ];

    public function accommodation()
    {
        return $this->belongsTo(Accommodation::class);
    }
}
