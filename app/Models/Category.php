<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'color', 'sort_order',
        'show_on_menu', 'is_active', 'language_id'
    ];

    protected $casts = [
        'show_on_menu' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_categories');
    }
}