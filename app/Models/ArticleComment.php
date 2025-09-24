<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $fillable = [
        'article_id',
        'user_id',
        'content',
    ];

    /**
     * Get the article that this comment belongs to
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the user who wrote this comment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted creation date
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('M d, Y \a\t g:i A');
    }

    /**
     * Get time ago format
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Scope for recent comments
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for comments by article
     */
    public function scopeForArticle($query, $articleId)
    {
        return $query->where('article_id', $articleId);
    }
}
