<?php

namespace App\Models;

use App\Services\BlogImageService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;
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

    public function photos(): HasMany
    {
        return $this->hasMany(BlogPostPhoto::class)
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    public function firstPhoto(): HasOne
    {
        return $this->hasOne(BlogPostPhoto::class)
            ->ofMany([
                'sort_order' => 'min',
                'id' => 'min',
            ]);
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

    public function getCustomThumbnailUrlAttribute(): ?string
    {
        return BlogImageService::resolveUrl($this->thumbnail_path);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        $customUrl = $this->custom_thumbnail_url;

        if ($customUrl !== null) {
            return $customUrl;
        }

        if ($this->relationLoaded('photos')) {
            return $this->photos->first()?->url;
        }

        if ($this->relationLoaded('firstPhoto')) {
            return $this->firstPhoto?->url;
        }

        return $this->photos()->first()?->url;
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
