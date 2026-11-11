@props([
    'id' => 'default',
    'photos' => [],
    'title' => '',
    'subtitle' => null,
    'itemLabel' => 'Foto',
    'maxWidth' => 'max-w-4xl',
    'downloadable' => false,
    'ctaUrl' => null,
    'ctaLabel' => null,
])

@php
    $normalizedPhotos = collect($photos)
        ->map(function ($item, $idx) use ($title, $itemLabel) {
            if (is_string($item)) {
                return [
                    'url' => $item,
                    'alt' => trim(($title ?: $itemLabel).' '.($idx + 1)),
                    'label' => $itemLabel.' '.($idx + 1),
                ];
            }

            return [
                'url' => $item['url'] ?? '',
                'alt' => $item['alt'] ?? ($item['label'] ?? trim(($title ?: $itemLabel).' '.($idx + 1))),
                'label' => $item['label'] ?? ($itemLabel.' '.($idx + 1)),
            ];
        })
        ->filter(fn ($item) => filled($item['url']))
        ->values()
        ->all();
@endphp

<div
    x-data="imageLightbox(@js($id), @js($normalizedPhotos))"
    x-init="init()"
    x-on:open-image-lightbox.window="handleOpenEvent($event.detail)"
>
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
        aria-label="{{ $title ?: 'Penampil gambar' }}"
        class="fixed inset-0 z-[90] flex items-center justify-center bg-slate-900/50 p-3 backdrop-blur-md select-none sm:p-6"
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
            class="relative flex max-h-[92vh] w-full {{ $maxWidth }} flex-col gap-3 overflow-hidden rounded-3xl border border-white/70 bg-white/95 p-4 text-slate-800 shadow-2xl backdrop-blur-xl sm:gap-4 sm:p-5"
        >
            <div class="flex items-center justify-between gap-3">
                <div class="flex min-w-0 items-center gap-3">
                    <span class="inline-flex flex-shrink-0 items-center rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary sm:text-sm">
                        {{ $itemLabel }} <span class="mx-1" x-text="currentIndex + 1"></span> dari <span class="ml-1" x-text="photos.length"></span>
                    </span>
                    @if ($title)
                        <span class="hidden truncate text-sm font-semibold text-slate-700 sm:inline">
                            {{ $title }}
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-2">
                    @if ($downloadable)
                        <a
                            :href="currentPhoto.url"
                            download
                            target="_blank"
                            rel="noopener"
                            class="inline-flex items-center gap-1.5 rounded-full bg-pondok-primary/10 px-3 py-1.5 text-xs font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            <span class="hidden sm:inline">Unduh</span>
                        </a>
                    @endif

                    <button
                        type="button"
                        x-on:click="close()"
                        aria-label="Tutup tampilan gambar"
                        class="inline-flex h-9 w-9 flex-shrink-0 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition hover:bg-pondok-primary/10 hover:text-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
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
                        aria-label="Sebelumnya"
                        class="absolute left-2.5 top-1/2 z-10 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-pondok-primary/15 bg-white/90 text-pondok-primary shadow-md backdrop-blur-sm transition hover:bg-pondok-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-pondok-primary/40 sm:left-3.5 sm:h-11 sm:w-11"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                </template>

                <div class="flex w-full items-center justify-center" :style="dragStyle">
                    <img
                        x-ref="mainImg"
                        :src="currentPhoto.url"
                        :alt="currentPhoto.alt"
                        draggable="false"
                        x-on:load="syncOrientation($event.target)"
                        :class="isPortrait ? 'h-[62vh] w-auto max-w-full rounded-2xl object-contain shadow-sm' : 'block h-auto max-h-[65vh] w-full rounded-2xl object-contain'"
                    >
                </div>

                <template x-if="photos.length > 1">
                    <button
                        type="button"
                        x-on:click.stop="next()"
                        aria-label="Berikutnya"
                        class="absolute right-2.5 top-1/2 z-10 inline-flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-pondok-primary/15 bg-white/90 text-pondok-primary shadow-md backdrop-blur-sm transition hover:bg-pondok-primary hover:text-white focus:outline-none focus:ring-2 focus:ring-pondok-primary/40 sm:right-3.5 sm:h-11 sm:w-11"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                        </svg>
                    </button>
                </template>
            </div>

            <div class="space-y-2.5">
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
                                :aria-label="`Pilih ${photo.label || index + 1}`"
                                class="relative h-12 w-16 flex-shrink-0 overflow-hidden rounded-xl transition duration-200 focus:outline-none sm:h-14 sm:w-20"
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

                <div class="flex flex-col items-center justify-between gap-2 sm:flex-row">
                    <div class="text-center sm:text-left">
                        @if ($title)
                            <p class="text-xs font-semibold text-slate-700 sm:hidden">{{ $title }}</p>
                        @endif
                        <p class="text-[11px] text-slate-500 sm:text-xs">
                            <span x-text="currentPhoto.label"></span>
                            @if ($subtitle)
                                <span> &bull; {{ $subtitle }}</span>
                            @endif
                        </p>
                    </div>

                    @if ($ctaUrl && $ctaLabel)
                        <a
                            href="{{ $ctaUrl }}"
                            class="inline-flex items-center gap-2 rounded-full bg-pondok-primary px-4 py-2 text-xs font-semibold text-white shadow-sm transition hover:bg-pondok-secondary"
                        >
                            {{ $ctaLabel }}
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            (() => {
                const registerImageLightbox = () => {
                    Alpine.data('imageLightbox', (lightboxId = 'default', photos = []) => ({
                        lightboxId,
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

                        handleOpenEvent(detail) {
                            if (!detail || (detail.id && detail.id !== this.lightboxId)) {
                                return;
                            }

                            this.open(Number(detail.index || 0));
                        },

                        get currentPhoto() {
                            return this.photos[this.currentIndex] || { url: '', alt: '', label: '' };
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
                    registerImageLightbox();
                } else {
                    document.addEventListener('alpine:init', registerImageLightbox);
                }
            })();
        </script>
    @endpush
@endonce
