<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BlogRepository
{
    public static function all(): Collection
    {
        $path = resource_path('data/blog.json');

        if (! File::exists($path)) {
            return collect();
        }

        $raw = json_decode(File::get($path), true) ?? [];

        Carbon::setLocale('id');

        return collect($raw)->map(function (array $post) {
            $date = isset($post['date']) ? Carbon::parse($post['date']) : null;

            return array_merge($post, [
                'formatted_date' => $date ? $date->translatedFormat('d F Y') : null,
                'reading_time' => $post['reading_time'] ?? null,
                'category_slug' => isset($post['category']) ? Str::slug($post['category']) : null,
            ]);
        });
    }

    public static function latest(int $take = 3): Collection
    {
        return self::all()
            ->sortByDesc('date')
            ->take($take)
            ->values();
    }
}
