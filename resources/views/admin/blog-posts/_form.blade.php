@php
    /** @var \App\Models\BlogPost|null $post */
    $post = $post ?? null;

    $existingPhotos = ($post && $post->relationLoaded('photos') ? $post->photos : collect())
        ->map(fn ($photo) => [
            'id' => $photo->id,
            'url' => $photo->url,
            'markedDelete' => false,
        ])
        ->filter(fn ($photo) => filled($photo['url']))
        ->values();
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

    <div class="grid gap-5 rounded-2xl border border-slate-200 bg-white p-5 md:grid-cols-2">
        <div>
            <label for="thumbnail" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Thumbnail Utama (Cover)
            </label>
            <input type="file" id="thumbnail" name="thumbnail" accept="image/jpeg,image/png,image/webp,image/*"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-pondok-primary focus:ring-pondok-primary">
            <p class="mt-1.5 text-[11px] text-slate-500">
                Opsional. Foto otomatis dikompres. Jika dikosongkan dan Galeri Foto diisi, foto galeri pertama otomatis menjadi cover.
            </p>
        </div>

        @if ($post?->custom_thumbnail_url)
            <div class="flex items-center gap-4">
                <img src="{{ $post->custom_thumbnail_url }}" alt="{{ $post->title }}" class="h-24 w-24 rounded-xl object-cover shadow-sm">
                <label class="flex items-center gap-2 text-xs font-semibold text-red-500">
                    <input type="checkbox" name="remove_thumbnail" value="1"
                        class="h-4 w-4 rounded border-red-300 text-red-500 focus:ring-red-400">
                    Hapus thumbnail khusus
                </label>
            </div>
        @elseif ($post?->thumbnail_url)
            <div class="flex items-center gap-4">
                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="h-24 w-24 rounded-xl object-cover shadow-sm">
                <div class="space-y-1 text-xs text-slate-500">
                    <span class="inline-flex rounded-full bg-pondok-primary/10 px-2.5 py-0.5 font-semibold text-pondok-primary">
                        Cover otomatis dari galeri
                    </span>
                    <p>Menggunakan foto pertama di galeri.</p>
                </div>
            </div>
        @endif
    </div>

    <div
        x-data="blogGalleryAdmin(@js($existingPhotos))"
        x-init="init()"
        class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5"
    >
        <div class="flex flex-wrap items-center justify-between gap-2">
            <div>
                <h3 class="text-xs font-semibold uppercase tracking-wide text-slate-600">
                    Galeri Foto Kegiatan
                </h3>
                <p class="mt-0.5 text-xs text-slate-500">
                    Pilih banyak foto sekaligus. Foto akan otomatis dikompres dan langsung muncul di bawah artikel.
                </p>
            </div>
            <span
                x-show="totalActiveCount > 0"
                x-cloak
                class="rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary"
                x-text="`${totalActiveCount} foto`"
            ></span>
        </div>

        <template x-if="existingPhotos.length > 0">
            <div class="space-y-2">
                <p class="text-xs font-semibold text-slate-600">Foto yang Sudah Terunggah</p>
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                    <template x-for="(photo, index) in existingPhotos" :key="photo.id">
                        <div
                            class="relative overflow-hidden rounded-xl border bg-slate-50 p-1.5 transition"
                            :class="photo.markedDelete ? 'border-red-300 bg-red-50/70 opacity-60' : 'border-slate-200'"
                        >
                            <input type="hidden" name="existing_photo_order[]" :value="photo.id">
                            <template x-if="photo.markedDelete">
                                <input type="hidden" name="delete_photo_ids[]" :value="photo.id">
                            </template>

                            <div class="relative aspect-square overflow-hidden rounded-lg bg-slate-100">
                                <img :src="photo.url" :alt="`Foto galeri ${index + 1}`" class="h-full w-full object-cover">
                                <span
                                    class="absolute left-1.5 top-1.5 rounded-full bg-black/65 px-2 py-0.5 text-[10px] font-semibold text-white"
                                    x-text="`#${index + 1}`"
                                ></span>
                                <template x-if="photo.markedDelete">
                                    <span class="absolute inset-0 flex items-center justify-center bg-red-900/50 text-[11px] font-semibold text-white">
                                        Akan dihapus
                                    </span>
                                </template>
                            </div>

                            <div class="mt-1.5 flex items-center justify-between gap-1">
                                <div class="flex items-center gap-1">
                                    <button
                                        type="button"
                                        x-on:click="moveExisting(index, -1)"
                                        :disabled="index === 0"
                                        title="Geser ke kiri"
                                        class="inline-flex h-6 w-6 items-center justify-center rounded-md border border-slate-200 bg-white text-xs text-slate-600 hover:bg-slate-100 disabled:opacity-35"
                                    >&larr;</button>
                                    <button
                                        type="button"
                                        x-on:click="moveExisting(index, 1)"
                                        :disabled="index === existingPhotos.length - 1"
                                        title="Geser ke kanan"
                                        class="inline-flex h-6 w-6 items-center justify-center rounded-md border border-slate-200 bg-white text-xs text-slate-600 hover:bg-slate-100 disabled:opacity-35"
                                    >&rarr;</button>
                                </div>
                                <button
                                    type="button"
                                    x-on:click="photo.markedDelete = !photo.markedDelete"
                                    class="rounded-md px-2 py-1 text-[11px] font-semibold transition"
                                    :class="photo.markedDelete ? 'bg-slate-200 text-slate-700 hover:bg-slate-300' : 'bg-red-100 text-red-600 hover:bg-red-500 hover:text-white'"
                                    x-text="photo.markedDelete ? 'Batal' : 'Hapus'"
                                ></button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        <div>
            <label for="gallery_photos" class="block text-xs font-semibold text-slate-600">
                Tambah Foto Galeri (Bisa Pilih Banyak Sekaligus)
            </label>
            <input
                x-ref="fileInput"
                type="file"
                id="gallery_photos"
                name="gallery_photos[]"
                multiple
                accept="image/jpeg,image/png,image/webp,image/*"
                x-on:change="handleFiles($event)"
                class="mt-1.5 w-full rounded-xl border border-dashed border-pondok-primary/40 bg-pondok-accent/50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-pondok-primary file:px-4 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-pondok-secondary"
            >
            <p class="mt-1.5 text-[11px] text-slate-400">
                Format JPG/PNG/WebP. Pilih hingga 20 foto per unggahan (bisa tambah lagi saat edit); ukuran diperkecil otomatis agar hemat kuota dan cepat.
            </p>
        </div>

        <div x-show="isCompressing" x-cloak class="flex items-center gap-2 rounded-xl bg-amber-50 px-4 py-2.5 text-xs font-medium text-amber-800">
            <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span x-text="statusText"></span>
        </div>

        <div x-show="!isCompressing && statusText" x-cloak class="rounded-xl bg-emerald-50 px-4 py-2 text-xs font-medium text-emerald-700" x-text="statusText"></div>

        <template x-if="queuedFiles.length > 0">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <p class="text-xs font-semibold text-slate-600">
                        Siap Diunggah (<span x-text="queuedFiles.length"></span> foto)
                    </p>
                    <button
                        type="button"
                        x-on:click="clearQueued()"
                        class="text-xs font-semibold text-red-600 hover:underline"
                    >
                        Kosongkan pilihan
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                    <template x-for="(item, index) in queuedFiles" :key="item.uid">
                        <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-1.5">
                            <div class="relative aspect-square overflow-hidden rounded-lg bg-slate-100">
                                <img :src="item.previewUrl" :alt="item.name" class="h-full w-full object-cover">
                                <button
                                    type="button"
                                    x-on:click="removeQueued(index)"
                                    title="Hapus dari antrean"
                                    class="absolute right-1.5 top-1.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-black/70 text-xs font-bold text-white hover:bg-red-600"
                                >&times;</button>
                            </div>
                            <p class="mt-1 truncate text-[10px] text-slate-500" x-text="item.sizeLabel"></p>
                        </div>
                    </template>
                </div>
            </div>
        </template>
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

@push('scripts')
    <script>
        (() => {
            const compressImageFile = (file) =>
                typeof window.ponpesCompressImageFile === 'function'
                    ? window.ponpesCompressImageFile(file, { maxDimension: 1600, quality: 0.84, minSkipSize: 350 * 1024 })
                    : Promise.resolve(file);

            const formatBytes = (bytes) =>
                typeof window.ponpesFormatBytes === 'function' ? window.ponpesFormatBytes(bytes) : `${Math.round(bytes / 1024)} KB`;

            const registerAdminGallery = () => {
                Alpine.data('blogGalleryAdmin', (initialExisting = []) => ({
                    existingPhotos: initialExisting,
                    queuedFiles: [],
                    isCompressing: false,
                    statusText: '',
                    compressionTask: null,

                    init() {
                        const form = this.$el.closest('form');
                        if (form) {
                            form.addEventListener('submit', async (event) => {
                                if (this.isCompressing && this.compressionTask) {
                                    event.preventDefault();
                                    await this.compressionTask;
                                    form.requestSubmit();
                                }
                            });
                        }

                        // Pre-compress single thumbnail input too when large.
                        const thumbInput = document.getElementById('thumbnail');
                        if (thumbInput) {
                            thumbInput.addEventListener('change', async () => {
                                const file = thumbInput.files && thumbInput.files[0];
                                if (!file || typeof DataTransfer === 'undefined') return;
                                const compressed = await compressImageFile(file);
                                try {
                                    const dt = new DataTransfer();
                                    dt.items.add(compressed);
                                    thumbInput.files = dt.files;
                                } catch (e) {
                                    // fallback: server GD still compresses
                                }
                            });
                        }
                    },

                    get totalActiveCount() {
                        const activeExisting = this.existingPhotos.filter((p) => !p.markedDelete).length;
                        return activeExisting + this.queuedFiles.length;
                    },

                    moveExisting(index, delta) {
                        const target = index + delta;
                        if (target < 0 || target >= this.existingPhotos.length) {
                            return;
                        }
                        const copy = [...this.existingPhotos];
                        const [moved] = copy.splice(index, 1);
                        copy.splice(target, 0, moved);
                        this.existingPhotos = copy;
                    },

                    async handleFiles(event) {
                        const selected = Array.from(event.target.files || []);
                        if (!selected.length) {
                            return;
                        }

                        this.isCompressing = true;
                        this.statusText = `Mengompres ${selected.length} foto...`;

                        const runCompression = async () => {
                            let originalBytes = 0;
                            let finalBytes = 0;
                            const nextItems = [];

                            for (let i = 0; i < selected.length; i++) {
                                const rawFile = selected[i];
                                originalBytes += rawFile.size;
                                this.statusText = `Mengompres foto ${i + 1} dari ${selected.length}...`;

                                const compressed = await compressImageFile(rawFile);
                                finalBytes += compressed.size;

                                nextItems.push({
                                    uid: `${Date.now()}-${Math.random().toString(36).slice(2)}-${i}`,
                                    file: compressed,
                                    name: compressed.name,
                                    sizeLabel: formatBytes(compressed.size),
                                    previewUrl: URL.createObjectURL(compressed),
                                });
                            }

                            const combined = [...this.queuedFiles, ...nextItems].slice(0, 20);
                            const wasCapped = (this.queuedFiles.length + nextItems.length) > 20;
                            this.queuedFiles = combined;
                            this.syncInputFiles();

                            this.isCompressing = false;
                            this.statusText = wasCapped
                                ? `Maksimal 20 foto per unggahan (${this.queuedFiles.length} foto siap). Sisanya bisa ditambahkan setelah disimpan.`
                                : `${nextItems.length} foto siap (${formatBytes(originalBytes)} -> ${formatBytes(finalBytes)}).`;
                        };

                        this.compressionTask = runCompression().finally(() => {
                            this.compressionTask = null;
                        });

                        await this.compressionTask;
                    },

                    removeQueued(index) {
                        const item = this.queuedFiles[index];
                        if (item?.previewUrl) {
                            URL.revokeObjectURL(item.previewUrl);
                        }
                        this.queuedFiles.splice(index, 1);
                        this.syncInputFiles();
                        if (!this.queuedFiles.length) {
                            this.statusText = '';
                        }
                    },

                    clearQueued() {
                        this.queuedFiles.forEach((item) => {
                            if (item.previewUrl) URL.revokeObjectURL(item.previewUrl);
                        });
                        this.queuedFiles = [];
                        this.syncInputFiles();
                        this.statusText = '';
                    },

                    syncInputFiles() {
                        const input = this.$refs.fileInput;
                        if (!input || typeof DataTransfer === 'undefined') {
                            return;
                        }
                        try {
                            const dt = new DataTransfer();
                            this.queuedFiles.forEach((item) => dt.items.add(item.file));
                            input.files = dt.files;
                        } catch (error) {
                            // Ignore if browser blocks programmatic FileList assignment
                        }
                    },
                }));
            };

            if (window.Alpine) {
                registerAdminGallery();
            } else {
                document.addEventListener('alpine:init', registerAdminGallery);
            }
        })();
    </script>
@endpush
