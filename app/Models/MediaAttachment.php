<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MediaAttachment extends Model
{
    protected $fillable = [
        'attachable_type', 'attachable_id', 'type', 'filename', 'original_name',
        'path', 'url', 'mime_type', 'size', 'metadata', 'sort_order'
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}