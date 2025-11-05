<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'category',
        'author',
        'reading_time',
        'thumbnail_path',
        'external_url',
        'published_at',
        'is_published',
        'is_featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (BlogPost $post) {
            if (blank($post->slug) && filled($post->title)) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function getFormattedDateAttribute(): ?string
    {
        /** @var Carbon|null $publishedAt */
        $publishedAt = $this->published_at;

        return $publishedAt ? $publishedAt->translatedFormat('d F Y') : null;
    }

    public function getCategorySlugAttribute(): ?string
    {
        return $this->category ? Str::slug($this->category) : null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if (blank($this->thumbnail_path)) {
            return null;
        }

        if (Str::startsWith($this->thumbnail_path, ['http://', 'https://'])) {
            return $this->thumbnail_path;
        }

        if (Storage::disk('public')->exists($this->thumbnail_path)) {
            return Storage::url($this->thumbnail_path);
        }

        $publicPath = public_path($this->thumbnail_path);

        if (file_exists($publicPath)) {
            return asset($this->thumbnail_path);
        }

        return null;
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: Str::random(6);
        $slug = $base;
        $counter = 2;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = "{$base}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}
