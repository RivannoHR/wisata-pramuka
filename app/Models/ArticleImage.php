<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    protected $fillable = [
        'article_id',
        'image_path',
        'sort_order'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
