@extends('layouts.app')

@section('title', 'Beranda | Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas')
@section('meta_description', 'Profil singkat Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas dengan program tahfidz, visi misi, nilai keikhlasan, dan informasi terbaru kegiatan pesantren.')

@section('content')
    <div
        x-data="promoModal()"
        x-init="init()"
        x-show="visible"
        x-transition.opacity
        x-cloak
        class="fixed inset-0 z-[70] flex items-center justify-center bg-black/60 p-4 sm:p-8"
    >
        <div class="relative w-full max-w-xl overflow-hidden rounded-3xl bg-white shadow-2xl md:max-w-2xl">
            <button
                type="button"
                class="absolute right-4 top-4 inline-flex h-9 w-9 items-center justify-center rounded-full bg-black/70 text-white transition hover:bg-black focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white/70"
                x-on:click="dismiss()"
                aria-label="Tutup brosur pendaftaran"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <img src="{{ asset('poster.jpg') }}" alt="Brosur Pendaftaran Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas"
                class="h-auto w-full object-cover">
        </div>
    </div>
@php
    $heroImage = null;
    $heroCandidates = [
        'foto pesantren.jpeg',
        'images/pondok-hero.jpg',
    ];

    foreach ($heroCandidates as $heroCandidate) {
        if (file_exists(public_path($heroCandidate))) {
            $heroImage = asset($heroCandidate);
            break;
        }
    }

    if (! $heroImage) {
        $heroImage = 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80';
    }
@endphp

    <section class="relative isolate overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ $heroImage }}" alt="Lingkungan Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas"
                class="h-full w-full object-cover brightness-90 md:object-center">
            <div class="absolute inset-0 bg-gradient-to-r from-pondok-primary/85 via-pondok-primary/80 to-transparent"></div>
        </div>

        <div class="relative mx-auto flex max-w-7xl flex-col gap-10 px-6 py-32 text-white lg:flex-row lg:items-center lg:px-10">
            <div class="max-w-2xl space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1 text-sm font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                    Mencetak Generasi Qur'ani
                </span>
                <h1 class="text-4xl font-bold leading-tight md:text-5xl lg:text-6xl">
                    Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas
                </h1>
                <p class="text-lg text-pondok-accent/90">
                    Menumbuhkan kecintaan pada Al-Qur’an melalui program tahfidz, pendidikan karakter, dan pendampingan
                    personal yang modern, hangat, dan penuh keikhlasan.
                </p>
                <div class="flex flex-wrap items-center gap-4">
                    <a href="{{ route('info') }}" class="btn-primary">
                        Lihat Program & Kegiatan
                    </a>
                    <a href="#nilai-pesantren"
                        class="inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-pondok-accent">
                        Nilai-Nilai Pesantren
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19V5m0 0l-7 7m7-7l7 7" />
                        </svg>
                    </a>
                </div>
            </div>
            <div class="grid w-full max-w-xl grid-cols-2 gap-4 rounded-3xl bg-white/10 p-6 backdrop-blur">
                @foreach ($statistics as $stat)
                    <div class="flex flex-col rounded-2xl bg-white/15 p-4 text-center">
                        <span class="text-3xl font-heading text-white">{{ $stat['value'] }}</span>
                        <span class="mt-1 text-xs text-pondok-accent/90">{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-pondok-accent py-16">
        <div class="mx-auto grid max-w-7xl gap-12 px-6 lg:grid-cols-2 lg:items-center lg:px-10">
            <div class="space-y-6">
                <h2 class="section-heading">Profil Singkat Pesantren</h2>
                <p class="text-base text-gray-600">
                    Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas berdiri untuk menghadirkan pendidikan Islam modern
                    berbasis tahfidz, yang memadukan kurikulum diniyah terpadu, pembinaan karakter, dan penguatan life-skill
                    santri. Lingkungan pesantren dirancang nyaman dan asri, mendukung fokus hafalan, belajar, sekaligus
                    tumbuhnya kreativitas santri.
                </p>
                <ul class="space-y-4">
                    @foreach ($highlights as $highlight)
                        <li class="flex gap-3 text-sm text-gray-600">
                            <span class="mt-1 inline-flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-pondok-primary/10 text-pondok-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </span>
                            <span>{{ $highlight }}</span>
                        </li>
                    @endforeach
                </ul>
                <div class="rounded-3xl bg-white p-6 shadow-soft">
                    <h3 class="text-lg font-semibold text-pondok-primary">Visi</h3>
                    <p class="mt-2 text-sm text-gray-600">
                        Menjadi pesantren tahfidz unggulan yang melahirkan generasi Qur’ani, berakhakul karimah, berilmu,
                        dan siap mengabdi untuk umat dan bangsa.
                    </p>
                    <h3 class="mt-6 text-lg font-semibold text-pondok-primary">Misi</h3>
                    <ul class="mt-3 space-y-2 text-sm text-gray-600">
                        <li>1. Menyelenggarakan program tahfidz yang terukur, menyeluruh, dan mutqin.</li>
                        <li>2. Mengintegrasikan kurikulum diniyah dan akademik umum yang adaptif.</li>
                        <li>3. Membina karakter kemandirian, kepemimpinan, dan kepedulian sosial santri.</li>
                    </ul>
                </div>
            </div>
            <div class="grid gap-5 md:grid-cols-2">
                @foreach ($programs as $program)
                    <x-card :title="$program['title']" :description="$program['description']" :icon="$program['icon']" />
                @endforeach
            </div>
        </div>
    </section>

    <section id="nilai-pesantren" class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col items-start gap-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Nilai-Nilai Pesantren</h2>
                    <p class="mt-3 max-w-2xl text-sm text-gray-600">
                        Nilai inti yang menjadi ruh pembinaan santri Nurul Ikhlas, menuntun setiap langkah untuk meraih
                        keberkahan ilmu dan kehidupan.
                    </p>
                </div>
                <a href="{{ route('info') }}" class="btn-primary text-sm">
                    Pelajari Lebih Lanjut
                </a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($values as $value)
                    <div class="rounded-3xl border border-pondok-primary/10 bg-pondok-accent/40 p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pondok-primary/10 text-pondok-primary">
                            {!! $value['icon'] !!}
                        </div>
                        <h3 class="mt-6 text-xl font-semibold text-pondok-primary">{{ $value['title'] }}</h3>
                        <p class="mt-3 text-sm text-gray-600">{{ $value['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-gradient-to-br from-white via-pondok-accent to-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="grid gap-12 lg:grid-cols-[1.3fr,1fr]">
                <div class="space-y-6">
                    <h2 class="section-heading">Pembinaan Santri Terstruktur</h2>
                    <p class="text-sm text-gray-600">
                        Pembelajaran berjalan dalam suasana menyenangkan dengan dukungan fasilitas lengkap: masjid pusat,
                        ruang tahfidz, perpustakaan, laboratorium bahasa, dan lapangan olahraga. Santri dibimbing oleh musyrif
                        berpengalaman dan seluruh aktivitas harian terjadwal dengan baik.
                    </p>
                    <div class="grid gap-5 md:grid-cols-2">
                        <div class="rounded-3xl bg-white p-6 shadow-soft">
                            <h4 class="text-lg font-semibold text-pondok-primary">Pendampingan Personal</h4>
                            <p class="mt-2 text-sm text-gray-600">Setiap santri mendapat pembimbing khusus untuk memastikan
                                perkembangan hafalan dan karakter.</p>
                        </div>
                        <div class="rounded-3xl bg-white p-6 shadow-soft">
                            <h4 class="text-lg font-semibold text-pondok-primary">Learning Journey</h4>
                            <p class="mt-2 text-sm text-gray-600">Monitoring berkala melalui buku mutaba'ah, aplikasi daring,
                                dan laporan rutin kepada orang tua.</p>
                        </div>
                    </div>
                </div>
                <div class="rounded-[2.5rem] bg-white p-8 shadow-soft">
                    <h3 class="text-lg font-semibold text-pondok-primary">Highlight Kegiatan Pekanan</h3>
                    <ul class="mt-6 space-y-4 text-sm text-gray-600">
                        <li class="flex gap-3">
                            <span class="mt-1 inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-pondok-primary/10 font-semibold text-pondok-primary">1</span>
                            <div>
                                <p class="font-medium text-pondok-primary">Tasmi’ Terbuka</p>
                                <p>Penyetoran hafalan di hadapan pengasuh dan santri, membangun kepercayaan diri.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-1 inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-pondok-primary/10 font-semibold text-pondok-primary">2</span>
                            <div>
                                <p class="font-medium text-pondok-primary">Spiritual Camp</p>
                                <p>Malam bina iman dan taqwa (MABIT) dengan materi akhlak, leadership, dan tilawah malam.</p>
                            </div>
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-1 inline-flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full bg-pondok-primary/10 font-semibold text-pondok-primary">3</span>
                            <div>
                                <p class="font-medium text-pondok-primary">Kelas Kreatif</p>
                                <p>Pelatihan design grafis, konten dakwah digital, dan jurnalistik santri.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    @php
        $galleryImages = [
            [
                'file' => 'foto pesantren.jpeg',
                'alt' => 'Suasana halaman utama Pondok Pesantren Nurul Ikhlas',
                'caption' => 'Suasana Pesantren',
            ],
            [
                'file' => 'fasilistas lapangan.jpeg',
                'alt' => 'Fasilitas lapangan olahraga Pondok Pesantren Nurul Ikhlas',
                'caption' => 'Fasilitas Lapangan',
            ],
            [
                'file' => 'asrama putri.png',
                'alt' => 'Asrama putri Pondok Pesantren Nurul Ikhlas',
                'caption' => 'Asrama Putri',
            ],
            [
                'file' => 'koperasi.png',
                'alt' => 'Koperasi santri Pondok Pesantren Nurul Ikhlas',
                'caption' => 'Koperasi Santri',
            ],
            [
                'file' => 'labolatorium.png',
                'alt' => 'Laboratorium kegiatan belajar Pondok Pesantren Nurul Ikhlas',
                'caption' => 'Laboratorium',
            ],
        ];
        $gallerySlides = array_chunk($galleryImages, 3);
        if (! empty($gallerySlides)) {
            $lastIndex = count($gallerySlides) - 1;
            $missingItems = 3 - count($gallerySlides[$lastIndex]);
            if ($missingItems > 0) {
                for ($i = 0; $i < $missingItems && $i < count($galleryImages); $i++) {
                    $gallerySlides[$lastIndex][] = $galleryImages[$i];
                }
            }
        }
    @endphp
    <section class="bg-pondok-accent/40 py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Galeri Pesantren</h2>
                    <p class="text-sm text-gray-600">Sekilas suasana kegiatan dan fasilitas yang mendukung pembinaan santri.</p>
                </div>
            </div>

            <div class="relative mt-10"
                x-data="galleryCarousel({ interval: 5000 })"
                x-init="init()"
                x-on:mouseenter="pause()"
                x-on:mouseleave="resume()"
            >
                <div class="overflow-hidden" x-ref="container">
                    <div class="flex" x-ref="track">
                        @foreach ($gallerySlides as $slide)
                            <div class="w-full flex-shrink-0">
                                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($slide as $image)
                                        <figure class="group relative overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-soft transition hover:-translate-y-1 hover:shadow-lg">
                                            <div class="aspect-[4/3] w-full overflow-hidden">
                                                <img src="{{ asset(rawurlencode($image['file'])) }}" alt="{{ $image['alt'] }}"
                                                    loading="lazy"
                                                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                            </div>
                                            <figcaption class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent px-6 py-4 text-sm font-medium text-white">
                                                {{ $image['caption'] }}
                                            </figcaption>
                                        </figure>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="pointer-events-none absolute inset-y-0 left-0 right-0 flex items-center justify-between px-3">
                    <button type="button"
                        class="pointer-events-auto inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/80 text-pondok-primary shadow transition hover:bg-white"
                        x-on:click="prev(); resume();"
                        aria-label="Slide sebelumnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button type="button"
                        class="pointer-events-auto inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/80 text-pondok-primary shadow transition hover:bg-white"
                        x-on:click="next(); resume();"
                        aria-label="Slide selanjutnya">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5L15.75 12l-7.5 7.5" />
                        </svg>
                    </button>
                </div>

                <div class="mt-6 flex justify-center gap-2">
                    <template x-for="index in total" :key="index">
                        <button type="button"
                            class="h-2 rounded-full transition"
                            :class="index - 1 === current ? 'w-6 bg-pondok-primary' : 'w-2 bg-pondok-primary/40'"
                            x-on:click="goTo(index - 1); resume();"
                            :aria-label="`Pilih slide ${index}`">
                        </button>
                    </template>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Artikel & Berita Terkini</h2>
                    <p class="text-sm text-gray-600">Rangkuman kegiatan dan kabar terbaru dari Pondok Pesantren Nurul Ikhlas.</p>
                </div>
                <a href="{{ route('blog') }}" class="btn-primary text-sm">Lihat Semua Artikel</a>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($blogPosts as $post)
                    @php
                        $thumbnail = $post->thumbnail_url
                            ?: 'https://images.unsplash.com/photo-1496280425805-1d58e5b61e7f?auto=format&fit=crop&w=800&q=80';
                    @endphp

                    <article class="group flex h-full flex-col overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="relative aspect-[4/3] overflow-hidden bg-pondok-accent">
                            <img src="{{ $thumbnail }}" alt="{{ $post->title }}"
                                class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-pondok-primary">
                                    {{ $post->category }}
                                </span>
                        </div>
                        <div class="flex flex-1 flex-col gap-4 p-6">
                            <div class="flex flex-wrap items-center gap-2 text-xs text-gray-500">
                                <span>{{ $post->formatted_date }}</span>
                                @if ($post->reading_time)
                                    <span class="text-gray-300">&bull;</span>
                                    <span>{{ $post->reading_time }}</span>
                                @endif
                            </div>
                            <h3 class="text-lg font-semibold text-pondok-primary">{{ $post->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $post->excerpt }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-pondok-primary hover:text-pondok-secondary">
                                    Baca Selengkapnya
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-pondok-primary py-16">
        <div class="mx-auto flex max-w-7xl flex-col items-center gap-6 px-6 text-center text-white lg:flex-row lg:justify-between lg:px-10">
            <div class="max-w-3xl space-y-4">
                <h2 class="text-3xl font-heading md:text-4xl">Siap Bergabung dengan Keluarga Besar Nurul Ikhlas?</h2>
                <p class="text-sm text-pondok-accent/90">
                    Segera daftarkan putra-putri Anda dan mari tumbuhkan generasi Qur’ani yang berwawasan luas, disiplin, dan
                    rendah hati. Kami menanti keluarga terbaik untuk bersama menebar cahaya Al-Qur’an.
                </p>
            </div>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('info') }}#pendaftaran" class="btn-primary bg-white text-pondok-primary hover:bg-pondok-accent hover:text-pondok-primary">
                    Informasi Pendaftaran
                </a>
                <a href="https://wa.me/6281234567890" target="_blank"
                    class="inline-flex items-center gap-2 rounded-xl border border-white/60 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    Konsultasi via WhatsApp
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12c0 5.385 4.365 9.75 9.75 9.75 1.7 0 3.291-.43 4.688-1.186L21.75 21l-.436-5.07A9.716 9.716 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12z" />
                    </svg>
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('promoModal', () => ({
                visible: false,
                timer: null,

                init() {
                    let dismissed = false;
                    try {
                        dismissed = sessionStorage.getItem('ponpesPosterDismissed');
                    } catch (error) {
                        dismissed = false;
                    }

                    if (dismissed) {
                        return;
                    }

                    this.visible = true;
                    this.timer = setTimeout(() => this.dismiss(), 5000);
                },

                dismiss() {
                    if (this.timer) {
                        clearTimeout(this.timer);
                        this.timer = null;
                    }

                    this.visible = false;
                    try {
                        sessionStorage.setItem('ponpesPosterDismissed', '1');
                    } catch (error) {
                        // ignore storage failures
                    }
                },
            }));

            Alpine.data('galleryCarousel', (config = {}) => ({
                current: 0,
                total: 0,
                interval: config.interval || 5000,
                timer: null,
                slides: [],
                slideWidth: 0,
                onResize: null,

                init() {
                    this.$nextTick(() => {
                        this.cacheSlides();
                        this.updateDimensions();
                        this.goTo(0, false);

                        if (this.total > 1) {
                            this.resume();
                        }

                        this.onResize = () => this.updateDimensions();
                        window.addEventListener('resize', this.onResize);

                        this.$el.addEventListener('alpine:destroy', () => {
                            this.pause();
                            if (this.onResize) {
                                window.removeEventListener('resize', this.onResize);
                            }
                        });
                    });
                },

                cacheSlides() {
                    this.slides = Array.from(this.$refs.track?.children || []);
                    this.total = this.slides.length;
                },

                updateDimensions() {
                    if (!this.$refs.container) {
                        return;
                    }

                    this.slideWidth = this.$refs.container.clientWidth;

                    if (this.slideWidth === 0) {
                        return;
                    }

                    this.slides.forEach((slide) => {
                        slide.style.width = `${this.slideWidth}px`;
                    });

                    this.applyTransform(false);
                },

                applyTransform(animate = true) {
                    if (!this.$refs.track) {
                        return;
                    }

                    if (!animate) {
                        this.$refs.track.style.transition = 'none';
                    } else {
                        this.$refs.track.style.transition = 'transform 600ms ease';
                    }

                    const offset = this.current * this.slideWidth;
                    this.$refs.track.style.transform = `translateX(-${offset}px)`;

                    if (!animate) {
                        requestAnimationFrame(() => {
                            if (this.$refs.track) {
                                this.$refs.track.style.transition = '';
                            }
                        });
                    }
                },

                goTo(index, animate = true) {
                    if (this.total === 0) {
                        return;
                    }

                    this.current = (index + this.total) % this.total;
                    this.applyTransform(animate);
                },

                next() {
                    if (this.total <= 1) {
                        return;
                    }

                    this.goTo(this.current + 1);
                },

                prev() {
                    if (this.total <= 1) {
                        return;
                    }

                    this.goTo(this.current - 1);
                },

                resume() {
                    if (this.total <= 1) {
                        return;
                    }

                    this.pause();
                    this.timer = setInterval(() => this.next(), this.interval);
                },

                pause() {
                    if (this.timer) {
                        clearInterval(this.timer);
                        this.timer = null;
                    }
                },
            }));
        });
    </script>
@endpush
