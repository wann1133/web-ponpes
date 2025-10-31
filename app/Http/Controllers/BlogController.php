<?php

namespace App\Http\Controllers;

use App\Support\BlogRepository;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogRepository::all()->sortByDesc('date')->values();
        $featured = $posts->first();

        $categories = $posts
            ->groupBy('category')
            ->map(fn (Collection $group) => [
                'name' => $group->first()['category'],
                'count' => $group->count(),
                'slug' => $group->first()['category_slug'],
            ])
            ->sortByDesc('count')
            ->values();

        return view('pages.blog', compact('posts', 'featured', 'categories'));
    }
}
