<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'title',
        'content',
        'img_path',
        'category'
    ];
    public function getCapitalTitleAttribute()
    {
        return ucfirst($this->title);
    }
    public function getCapitalCategoryAttribute()
    {
        return ucfirst($this->category);
    }
    protected function formattedDate(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->created_at ? $this->created_at->format('j F Y') : 'N/A',
        );
    }

    public function images()
    {
        return $this->hasMany(ArticleImage::class);
    }

    public function comments()
    {
        return $this->hasMany(ArticleComment::class);
    }

    public function getFirstImageAttribute()
    {
        $firstImage = $this->images()->orderBy('sort_order', 'asc')->first();
        return $firstImage ? $firstImage->image_path : null;
    }
}
