@php
    /** @var \App\Models\BlogPost|null $post */
    $post = $post ?? null;
@endphp

<div class="space-y-6">
    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="title" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Judul Artikel
            </label>
            <input type="text" id="title" name="title" value="{{ old('title', $post?->title) }}" required
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>
        <div>
            <label for="slug" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Slug URL
            </label>
            <input type="text" id="slug" name="slug" value="{{ old('slug', $post?->slug) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                placeholder="otomatis dibuat jika dikosongkan">
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="category" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Kategori
            </label>
            <input type="text" id="category" name="category" value="{{ old('category', $post?->category) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>
        <div>
            <label for="author" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Penulis
            </label>
            <input type="text" id="author" name="author" value="{{ old('author', $post?->author) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label for="reading_time" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Durasi Baca
            </label>
            <input type="text" id="reading_time" name="reading_time" value="{{ old('reading_time', $post?->reading_time) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                placeholder="Contoh: 4 menit">
        </div>
        <div>
            <label for="published_at" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Tanggal Terbit
            </label>
            <input type="datetime-local" id="published_at" name="published_at"
                value="{{ old('published_at', optional($post?->published_at)->format('Y-m-d\TH:i')) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>
        <div>
            <label for="external_url" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                URL Artikel Lengkap
            </label>
            <input type="url" id="external_url" name="external_url" value="{{ old('external_url', $post?->external_url) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                placeholder="Opsional, jika artikel ada di laman lain">
        </div>
    </div>

    <div>
        <label for="excerpt" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Ringkasan (Excerpt)
        </label>
        <textarea id="excerpt" name="excerpt" rows="3"
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('excerpt', $post?->excerpt) }}</textarea>
    </div>

    <div>
        <label for="body" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Konten Lengkap (Opsional)
        </label>
        <textarea id="body" name="body" rows="6"
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('body', $post?->body) }}</textarea>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="thumbnail" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Thumbnail
            </label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/*"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-pondok-primary focus:ring-pondok-primary">
            <p class="mt-1 text-[11px] text-slate-400">Format JPG/PNG, maksimal 5 MB.</p>
        </div>

        @if ($post?->thumbnail_url)
            <div class="flex gap-3">
                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="h-24 w-24 rounded-xl object-cover">
                <label class="flex items-center gap-2 text-xs font-semibold text-red-500">
                    <input type="checkbox" name="remove_thumbnail" value="1"
                        class="h-4 w-4 rounded border-red-300 text-red-500 focus:ring-red-400">
                    Hapus thumbnail
                </label>
            </div>
        @endif
    </div>

    <div class="flex flex-wrap items-center gap-4 text-xs text-slate-600">
        <label class="inline-flex items-center gap-2 font-semibold text-pondok-primary">
            <input type="checkbox" name="is_published" value="1"
                class="h-4 w-4 rounded border-pondok-primary text-pondok-primary focus:ring-pondok-primary"
                @checked(old('is_published', $post?->is_published ?? true))>
            Terbitkan artikel
        </label>

        <label class="inline-flex items-center gap-2 font-semibold text-pondok-primary">
            <input type="checkbox" name="is_featured" value="1"
                class="h-4 w-4 rounded border-pondok-primary text-pondok-primary focus:ring-pondok-primary"
                @checked(old('is_featured', $post?->is_featured))>
            Tampilkan sebagai sorotan
        </label>
    </div>
</div>
