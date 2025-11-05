<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogPost;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::orderByDesc('published_at')->orderByDesc('created_at')->get();

        return view('admin.blog-posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blog-posts.create', ['post' => new BlogPost()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $request)
    {
        $data = $this->prepareData($request->validated());

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $request->file('thumbnail')->store('blog', 'public');
        }

        unset($data['thumbnail'], $data['remove_thumbnail']);

        $post = BlogPost::create($data);

        if ($post->is_featured) {
            BlogPost::where('id', '!=', $post->id)->update(['is_featured' => false]);
        }

        return redirect()
            ->route('admin.blog-posts.edit', $post)
            ->with('status', 'Artikel blog berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogPost $blogPost)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog-posts.edit', ['post' => $blogPost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostRequest $request, BlogPost $blogPost)
    {
        $data = $this->prepareData($request->validated(), $blogPost);

        if ($request->boolean('remove_thumbnail')) {
            $this->deleteThumbnail($blogPost);
            $data['thumbnail_path'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $this->deleteThumbnail($blogPost);
            $data['thumbnail_path'] = $request->file('thumbnail')->store('blog', 'public');
        }

        unset($data['thumbnail'], $data['remove_thumbnail']);

        $blogPost->update($data);

        if ($blogPost->is_featured) {
            BlogPost::where('id', '!=', $blogPost->id)->update(['is_featured' => false]);
        }

        return redirect()
            ->route('admin.blog-posts.edit', $blogPost)
            ->with('status', 'Artikel blog berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        $this->deleteThumbnail($blogPost);
        $blogPost->delete();

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('status', 'Artikel blog berhasil dihapus.');
    }

    private function prepareData(array $data, ?BlogPost $post = null): array
    {
        if (blank($data['slug'] ?? null) && filled($data['title'] ?? null)) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (($data['is_published'] ?? false) && empty($data['published_at'])) {
            $data['published_at'] = $post?->published_at ?? now();
        }

        if (! ($data['is_published'] ?? false)) {
            $data['published_at'] = null;
            $data['is_featured'] = false;
        }

        return $data;
    }

    private function deleteThumbnail(BlogPost $post): void
    {
        $path = $post->thumbnail_path;

        if (blank($path) || Str::startsWith($path, ['http://', 'https://'])) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
