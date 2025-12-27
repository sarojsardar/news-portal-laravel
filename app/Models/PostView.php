<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostView extends Model
{
    protected $fillable = [
        'post_id', 'user_id', 'ip_address', 'user_agent', 'referer', 'viewed_at'
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public $timestamps = false;

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}