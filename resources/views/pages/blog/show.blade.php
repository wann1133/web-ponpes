@extends('layouts.app')

@section('title', $post->title.' | Blog Pesantren Nurul Ikhlas')
@section('meta_description', $post->excerpt ?? 'Artikel terbaru Pondok Pesantren Nurul Ikhlas.')
@section('og_title', $post->title.' | Blog Pesantren Nurul Ikhlas')
@section('og_description', $post->excerpt ?? 'Artikel terbaru Pondok Pesantren Nurul Ikhlas.')

@php
    $heroImage = $post->thumbnail_url
        ?: 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1600&q=80';
    $bodyHtml = $post->body ? nl2br(e($post->body)) : null;

    $galleryPhotos = $post->photos
        ->map(function ($photo, $index) use ($post) {
            $url = $photo->url;
            if (! $url) {
                return null;
            }

            return [
                'url' => $url,
                'alt' => $post->title.' - Foto '.($index + 1),
            ];
        })
        ->filter()
        ->values();

    $totalPhotos = $galleryPhotos->count();
    $previewLimit = 6;
    $previewPhotos = $galleryPhotos->take($previewLimit);
    $remainingPhotos = max(0, $totalPhotos - $previewLimit);
@endphp

@section('og_image', $heroImage)

@section('content')
    <section class="bg-pondok-accent py-16">
        <div class="mx-auto max-w-5xl px-6 lg:px-10">
            <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-pondok-primary hover:text-pondok-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Blog
            </a>
            <div class="mt-6 space-y-4">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/80 px-3 py-1 text-xs font-semibold text-pondok-primary">
                    {{ $post->category ?? 'Artikel' }}
                </span>
                <h1 class="text-4xl font-heading text-pondok-primary md:text-5xl">
                    {{ $post->title }}
                </h1>
                <div class="flex flex-wrap items-center gap-3 text-xs text-gray-600">
                    <span>{{ $post->formatted_date }}</span>
                    <span class="h-1 w-1 rounded-full bg-gray-400"></span>
                    <span>{{ $post->author ?? 'Tim Humas' }}</span>
                    @if ($post->reading_time)
                        <span class="h-1 w-1 rounded-full bg-gray-400"></span>
                        <span>{{ $post->reading_time }}</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-5xl px-6 lg:px-10">
            <div class="overflow-hidden rounded-[2.5rem] bg-white shadow-soft">
                <div class="relative h-72 w-full overflow-hidden bg-pondok-accent md:h-[420px]">
                    <img src="{{ $heroImage }}" alt="{{ $post->title }}" class="absolute inset-0 h-full w-full object-cover">
                </div>

                <article class="space-y-5 px-6 py-10 text-sm text-gray-700 lg:px-12 lg:text-base">
                    @if ($bodyHtml)
                        {!! $bodyHtml !!}
                    @else
                        <p>Konten artikel akan segera hadir.</p>
                    @endif
                </article>

                @if ($totalPhotos > 0)
                    <div
                        x-data="blogPhotoLightbox(@js($galleryPhotos->all()))"
                        x-init="init()"
                        class="border-t border-pondok-primary/10 px-6 py-8 lg:px-12 lg:py-10"
                    >
                        <div class="flex items-center justify-between gap-4">
                            <h2 class="text-lg font-semibold text-pondok-primary md:text-xl">Galeri foto</h2>
                            <span class="rounded-full bg-pondok-accent px-3 py-1 text-xs font-semibold text-pondok-primary sm:text-sm">
                                {{ $totalPhotos }} foto
                            </span>
                        </div>

                        <div class="mt-4 grid grid-cols-3 gap-2.5 sm:gap-4">
                            @foreach ($previewPhotos as $index => $photo)
                                <button
                                    type="button"
                                    x-on:click="open({{ $index }})"
                                    aria-label="Lihat foto {{ $index + 1 }} dari {{ $totalPhotos }}"
                                    class="group relative aspect-square w-full overflow-hidden rounded-2xl bg-pondok-accent focus:outline-none focus:ring-2 focus:ring-pondok-primary focus:ring-offset-2"
                                >
                                    <img
                                        src="{{ $photo['url'] }}"
                                        alt="{{ $photo['alt'] }}"
                                        loading="lazy"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                                    >
                                    @if ($loop->last && $remainingPhotos > 0)
                                        <span class="absolute inset-0 flex items-center justify-center bg-black/55 text-white transition group-hover:bg-black/65">
                                            <span class="text-lg font-bold tracking-tight sm:text-2xl">+{{ $remainingPhotos }}</span>
                                        </span>
                                    @endif
                                </button>
                            @endforeach
                        </div>

                        <p class="mt-3 text-center text-xs text-gray-400">
                            Ketuk salah satu foto di galeri
                        </p>

                        <div
                            x-show="isOpen"
                            x-cloak
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            role="dialog"
                            aria-modal="true"
                            aria-label="Penampil foto penuh"
                            class="fixed inset-0 z-[80] flex items-center justify-center bg-slate-900/45 p-3 backdrop-blur-md select-none sm:p-6"
                            x-on:click.self="close()"
                            x-on:keydown.escape.window="isOpen && close()"
                            x-on:keydown.arrow-right.window="isOpen && next()"
                            x-on:keydown.arrow-left.window="isOpen && prev()"
                        >
                            <div
                                x-show="isOpen"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                                x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                                x-on:click.stop
                                class="relative flex max-h-[92vh] w-full max-w-3xl flex-col gap-3 overflow-hidden rounded-3xl border border-white/70 bg-white/95 p-4 text-slate-800 shadow-2xl backdrop-blur-xl sm:gap-4 sm:p-5"
                            >
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex min-w-0 items-center gap-3">
                                        <span class="inline-flex flex-shrink-0 items-center rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary sm:text-sm">
                                            Foto <span class="mx-1" x-text="currentIndex + 1"></span> dari <span class="ml-1" x-text="photos.length"></span>
                                        </span>
                                        <span class="hidden truncate text-sm font-semibold text-slate-700 sm:inline">
                                            {{ $post->title }}
                                        </span>
                                    </div>

                                    <button
                                        type="button"
                                        x-on:click="close()"
                                        aria-label="Tutup galeri foto"
                                        class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-pondok-primary/10 hover:text-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div
                                    class="relative w-full overflow-hidden rounded-2xl"
                                    x-on:touchstart.passive="onTouchStart($event)"
                                    x-on:touchmove.passive="onTouchMove($event)"
                                    x-on:touchend="onTouchEnd($event)"
                                >
                                    <template x-if="photos.length > 1">
                                        <button
                                            type="button"
                                            x-on:click.stop="prev()"
                                            aria-label="Foto sebelumnya"
                                            class="absolute left-2.5 top-1/2 z-10 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-pondok-primary/15 bg-white/85 text-pondok-primary shadow-md backdrop-blur-sm transition hover:bg-pondok-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-pondok-primary/40 sm:left-3.5 sm:h-11 sm:w-11"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                                            </svg>
                                        </button>
                                    </template>

                                    <div
                                        class="flex w-full items-center justify-center"
                                        :style="dragStyle"
                                    >
                                        <img
                                            x-ref="mainImg"
                                            :src="currentPhoto.url"
                                            :alt="currentPhoto.alt"
                                            draggable="false"
                                            x-on:load="syncOrientation($event.target)"
                                            :class="isPortrait ? 'h-[60vh] w-auto max-w-full rounded-2xl object-contain shadow-sm' : 'block h-auto max-h-[65vh] w-full rounded-2xl object-contain'"
                                        >
                                    </div>

                                    <template x-if="photos.length > 1">
                                        <button
                                            type="button"
                                            x-on:click.stop="next()"
                                            aria-label="Foto berikutnya"
                                            class="absolute right-2.5 top-1/2 z-10 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-pondok-primary/15 bg-white/85 text-pondok-primary shadow-md backdrop-blur-sm transition hover:bg-pondok-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-pondok-primary/40 sm:right-3.5 sm:h-11 sm:w-11"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                                            </svg>
                                        </button>
                                    </template>
                                </div>

                                <div class="space-y-2">
                                    <template x-if="photos.length > 1">
                                        <div
                                            x-ref="thumbStrip"
                                            class="flex items-center gap-2 overflow-x-auto px-1 py-1 sm:justify-center"
                                        >
                                            <template x-for="(photo, index) in photos" :key="index">
                                                <button
                                                    type="button"
                                                    :data-thumb-index="index"
                                                    x-on:click="goTo(index)"
                                                    :aria-label="`Pilih foto ${index + 1}`"
                                                    class="relative h-12 w-12 flex-shrink-0 overflow-hidden rounded-xl transition duration-200 focus:outline-none sm:h-14 sm:w-14"
                                                    :class="index === currentIndex ? 'ring-2 ring-pondok-primary ring-offset-2 opacity-100 scale-105' : 'opacity-55 hover:opacity-90'"
                                                >
                                                    <img
                                                        :src="photo.url"
                                                        :alt="photo.alt"
                                                        loading="lazy"
                                                        class="h-full w-full object-cover"
                                                    >
                                                </button>
                                            </template>
                                        </div>
                                    </template>

                                    <div class="text-center">
                                        <p class="text-xs font-semibold text-slate-700 line-clamp-1 sm:hidden">
                                            {{ $post->title }}
                                        </p>
                                        <p class="text-[11px] text-slate-500 sm:text-xs">
                                            <span>{{ $post->formatted_date }}</span>
                                            <template x-if="photos.length > 1">
                                                <span> &bull; Geser foto, pilih thumbnail, atau tekan panah</span>
                                            </template>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if ($post->external_url)
                <div class="mt-6 rounded-3xl bg-pondok-accent/60 px-6 py-5 text-sm text-pondok-primary shadow-sm md:flex md:items-center md:justify-between md:gap-4 md:px-8">
                    <p class="font-semibold">Butuh detail tambahan?</p>
                    <a href="{{ $post->external_url }}" target="_blank"
                        class="inline-flex items-center gap-2 rounded-full bg-pondok-primary px-4 py-2 text-xs font-semibold text-white transition hover:bg-pondok-secondary">
                        Baca di sumber eksternal
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </section>

    <section class="bg-pondok-accent/40 py-16">
        <div class="mx-auto max-w-5xl px-6 lg:px-10">
            <h2 class="text-xl font-semibold text-pondok-primary">Artikel Lainnya</h2>
            <div class="mt-6 grid gap-6 md:grid-cols-2">
                @forelse ($recent as $item)
                    <a href="{{ route('blog.show', $item) }}"
                        class="flex h-full flex-col overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="relative aspect-[4/3] overflow-hidden bg-pondok-accent">
                            @php
                                $thumb = $item->thumbnail_url
                                    ?: 'https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?auto=format&fit=crop&w=800&q=80';
                            @endphp
                            <img src="{{ $thumb }}" alt="{{ $item->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-500 hover:scale-105">
                            @if ($item->category)
                                <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-pondok-primary">
                                    {{ $item->category }}
                                </span>
                            @endif
                            <x-blog-photo-badge :count="$item->photos_count ?? 0" />
                        </div>
                        <div class="flex flex-1 flex-col gap-3 p-6">
                            <div class="text-xs text-gray-500">
                                {{ $item->formatted_date }} @if ($item->reading_time) &bull; {{ $item->reading_time }} @endif
                            </div>
                            <h3 class="text-lg font-semibold text-pondok-primary">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $item->excerpt }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-sm text-gray-500">Belum ada artikel lainnya.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@if ($totalPhotos > 0)
    @push('scripts')
        <script>
            (() => {
                const registerLightbox = () => {
                    Alpine.data('blogPhotoLightbox', (photos = []) => ({
                        photos,
                        isOpen: false,
                        currentIndex: 0,
                        isPortrait: false,
                        touchStartX: null,
                        touchStartY: null,
                        touchDeltaX: 0,
                        isSwipingHorizontal: false,

                        init() {
                            this.$el.addEventListener('alpine:destroy', () => {
                                document.body.classList.remove('overflow-hidden');
                            });
                        },

                        get currentPhoto() {
                            return this.photos[this.currentIndex] || { url: '', alt: '' };
                        },

                        get dragStyle() {
                            if (!this.isSwipingHorizontal || this.touchDeltaX === 0) {
                                return 'transition: transform 200ms ease; transform: translateX(0px);';
                            }

                            return `transition: none; transform: translateX(${this.touchDeltaX}px);`;
                        },

                        syncOrientation(img) {
                            if (!img || !img.naturalWidth) {
                                return;
                            }

                            this.isPortrait = img.naturalHeight > img.naturalWidth;
                        },

                        open(index = 0) {
                            if (!this.photos.length) {
                                return;
                            }

                            this.currentIndex = Math.max(0, Math.min(index, this.photos.length - 1));
                            this.isOpen = true;
                            document.body.classList.add('overflow-hidden');
                            this.$nextTick(() => {
                                this.syncOrientation(this.$refs.mainImg);
                                this.scrollActiveThumb();
                            });
                        },

                        close() {
                            this.isOpen = false;
                            this.resetTouch();
                            document.body.classList.remove('overflow-hidden');
                        },

                        goTo(index) {
                            if (!this.photos.length) {
                                return;
                            }

                            this.currentIndex = Math.max(0, Math.min(index, this.photos.length - 1));
                            this.$nextTick(() => {
                                this.syncOrientation(this.$refs.mainImg);
                                this.scrollActiveThumb();
                            });
                        },

                        next() {
                            if (this.photos.length <= 1) {
                                return;
                            }

                            this.goTo((this.currentIndex + 1) % this.photos.length);
                        },

                        prev() {
                            if (this.photos.length <= 1) {
                                return;
                            }

                            this.goTo((this.currentIndex - 1 + this.photos.length) % this.photos.length);
                        },

                        scrollActiveThumb() {
                            const strip = this.$refs.thumbStrip;
                            if (!strip) {
                                return;
                            }

                            const activeBtn = strip.querySelector(`[data-thumb-index="${this.currentIndex}"]`);
                            if (activeBtn && typeof activeBtn.scrollIntoView === 'function') {
                                activeBtn.scrollIntoView({ behavior: 'smooth', inline: 'center', block: 'nearest' });
                            }
                        },

                        onTouchStart(event) {
                            if (this.photos.length <= 1 || event.touches.length !== 1) {
                                return;
                            }

                            this.touchStartX = event.touches[0].clientX;
                            this.touchStartY = event.touches[0].clientY;
                            this.touchDeltaX = 0;
                            this.isSwipingHorizontal = false;
                        },

                        onTouchMove(event) {
                            if (this.touchStartX === null || event.touches.length !== 1) {
                                return;
                            }

                            const dx = event.touches[0].clientX - this.touchStartX;
                            const dy = event.touches[0].clientY - this.touchStartY;

                            if (!this.isSwipingHorizontal && Math.abs(dx) > Math.abs(dy) && Math.abs(dx) > 10) {
                                this.isSwipingHorizontal = true;
                            }

                            if (this.isSwipingHorizontal) {
                                this.touchDeltaX = dx;
                            }
                        },

                        onTouchEnd() {
                            if (this.isSwipingHorizontal) {
                                if (this.touchDeltaX <= -45) {
                                    this.next();
                                } else if (this.touchDeltaX >= 45) {
                                    this.prev();
                                }
                            }

                            this.resetTouch();
                        },

                        resetTouch() {
                            this.touchStartX = null;
                            this.touchStartY = null;
                            this.touchDeltaX = 0;
                            this.isSwipingHorizontal = false;
                        },
                    }));
                };

                if (window.Alpine) {
                    registerLightbox();
                } else {
                    document.addEventListener('alpine:init', registerLightbox);
                }
            })();
        </script>
    @endpush
@endif
