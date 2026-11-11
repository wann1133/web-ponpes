<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BlogPostRequest;
use App\Models\BlogPost;
use App\Models\BlogPostPhoto;
use App\Services\BlogImageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function __construct(private readonly BlogImageService $imageService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BlogPost::withCount('photos')
            ->with('firstPhoto')
            ->orderByDesc('published_at')
            ->orderByDesc('created_at')
            ->get();

        return view('admin.blog-posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $post = new BlogPost();
        $post->setRelation('photos', collect());

        return view('admin.blog-posts.create', ['post' => $post]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BlogPostRequest $request)
    {
        $validated = $request->validated();
        $data = $this->prepareData($this->extractPostAttributes($validated));

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->storeThumbnail($request->file('thumbnail'));
        }

        $post = DB::transaction(function () use ($data, $request) {
            $post = BlogPost::create($data);

            if ($post->is_featured) {
                BlogPost::where('id', '!=', $post->id)->update(['is_featured' => false]);
            }

            $this->appendGalleryPhotos($post, $request->file('gallery_photos', []));

            return $post;
        });

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
        $blogPost->load('photos');

        return view('admin.blog-posts.edit', ['post' => $blogPost]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BlogPostRequest $request, BlogPost $blogPost)
    {
        $validated = $request->validated();
        $data = $this->prepareData($this->extractPostAttributes($validated), $blogPost);

        if ($request->boolean('remove_thumbnail')) {
            $this->imageService->deleteFile($blogPost->thumbnail_path);
            $data['thumbnail_path'] = null;
        }

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail_path'] = $this->storeThumbnail($request->file('thumbnail'), $blogPost);
        }

        DB::transaction(function () use ($blogPost, $data, $validated, $request) {
            $blogPost->update($data);

            if ($blogPost->is_featured) {
                BlogPost::where('id', '!=', $blogPost->id)->update(['is_featured' => false]);
            }

            $this->syncExistingGalleryPhotos(
                $blogPost,
                $validated['delete_photo_ids'] ?? [],
                $validated['existing_photo_order'] ?? []
            );

            $this->appendGalleryPhotos($blogPost, $request->file('gallery_photos', []));
        });

        return redirect()
            ->route('admin.blog-posts.edit', $blogPost)
            ->with('status', 'Artikel blog berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogPost $blogPost)
    {
        $blogPost->load('photos');

        $this->imageService->deleteFile($blogPost->thumbnail_path);

        foreach ($blogPost->photos as $photo) {
            $this->imageService->deleteFile($photo->file_path);
        }

        $blogPost->delete();

        return redirect()
            ->route('admin.blog-posts.index')
            ->with('status', 'Artikel blog berhasil dihapus.');
    }

    private function extractPostAttributes(array $validated): array
    {
        return Arr::except($validated, [
            'thumbnail',
            'remove_thumbnail',
            'gallery_photos',
            'existing_photo_order',
            'delete_photo_ids',
        ]);
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

    private function storeThumbnail(UploadedFile $file, ?BlogPost $existing = null): string
    {
        if ($existing) {
            $this->imageService->deleteFile($existing->thumbnail_path);
        }

        return $this->imageService->storeCompressed($file, 'images/blog', 1400, 82);
    }

    /**
     * @param  array<int, UploadedFile|mixed>  $files
     */
    private function appendGalleryPhotos(BlogPost $post, array $files): void
    {
        $validFiles = array_values(array_filter(
            $files,
            fn ($file) => $file instanceof UploadedFile && $file->isValid()
        ));

        if ($validFiles === []) {
            return;
        }

        $nextOrder = ((int) $post->photos()->max('sort_order')) + 10;

        foreach ($validFiles as $file) {
            $path = $this->imageService->storeCompressed($file, 'images/blog/gallery', 1600, 82);

            $post->photos()->create([
                'file_path' => $path,
                'sort_order' => $nextOrder,
            ]);

            $nextOrder += 10;
        }
    }

    /**
     * @param  array<int, int|string>  $deleteIds
     * @param  array<int, int|string>  $orderedIds
     */
    private function syncExistingGalleryPhotos(BlogPost $post, array $deleteIds, array $orderedIds): void
    {
        $deleteIdList = array_values(array_unique(array_map('intval', $deleteIds)));

        if ($deleteIdList !== []) {
            $photosToDelete = $post->photos()->whereIn('id', $deleteIdList)->get();

            foreach ($photosToDelete as $photo) {
                $this->imageService->deleteFile($photo->file_path);
                $photo->delete();
            }
        }

        $remainingPhotos = $post->photos()->get()->keyBy('id');

        if ($remainingPhotos->isEmpty()) {
            return;
        }

        $sortOrder = 10;
        $processedIds = [];

        foreach ($orderedIds as $rawId) {
            $photoId = (int) $rawId;
            /** @var BlogPostPhoto|null $photo */
            $photo = $remainingPhotos->get($photoId);

            if (! $photo || isset($processedIds[$photoId])) {
                continue;
            }

            if ($photo->sort_order !== $sortOrder) {
                $photo->update(['sort_order' => $sortOrder]);
            }

            $processedIds[$photoId] = true;
            $sortOrder += 10;
        }

        foreach ($remainingPhotos as $photoId => $photo) {
            if (isset($processedIds[$photoId])) {
                continue;
            }

            $photo->update(['sort_order' => $sortOrder]);
            $sortOrder += 10;
        }
    }
}
