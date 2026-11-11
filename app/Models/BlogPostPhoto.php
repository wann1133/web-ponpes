<?php

namespace App\Models;

use App\Services\BlogImageService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPostPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'blog_post_id',
        'file_path',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function getUrlAttribute(): ?string
    {
        return BlogImageService::resolveUrl($this->file_path);
    }
}

