<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        Carbon::setLocale('id');

        $posts = BlogPost::published()
            ->orderByDesc('published_at')
            ->get();

        $featured = $posts->firstWhere('is_featured', true) ?? $posts->first();

        $categories = $posts
            ->groupBy(fn (BlogPost $post) => $post->category)
            ->map(fn (Collection $group) => [
                'name' => $group->first()?->category,
                'count' => $group->count(),
                'slug' => $group->first()?->category_slug,
            ])
            ->sortByDesc('count')
            ->values();

        return view('pages.blog', compact('posts', 'featured', 'categories'));
    }

    public function show(BlogPost $post): View
    {
        if (! $post->is_published || blank($post->published_at) || $post->published_at->isFuture()) {
            abort(Response::HTTP_NOT_FOUND);
        }

        $recent = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->take(4)
            ->get();

        return view('pages.blog.show', [
            'post' => $post,
            'recent' => $recent,
        ]);
    }
}
