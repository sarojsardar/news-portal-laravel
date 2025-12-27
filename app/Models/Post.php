<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Post extends Model
{
    protected $fillable = [
        'title', 'slug', 'subtitle', 'excerpt', 'content', 'type', 'status',
        'featured_image', 'meta_data', 'published_at', 'views_count', 'likes_count',
        'comments_count', 'is_featured', 'is_breaking', 'allow_comments',
        'user_id', 'language_id'
    ];

    protected $casts = [
        'meta_data' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
        'allow_comments' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'post_categories');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function mediaAttachments(): MorphMany
    {
        return $this->morphMany(MediaAttachment::class, 'attachable');
    }

    public function views(): HasMany
    {
        return $this->hasMany(PostView::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBreaking($query)
    {
        return $query->where('is_breaking', true);
    }
}