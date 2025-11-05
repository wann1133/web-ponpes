@extends('layouts.app')

@section('title', 'Blog | Pondok Pesantren Nurul Ikhlas')
@section('meta_description', 'Kumpulan artikel kegiatan, berita prestasi, dan informasi terbaru Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas.')

@section('content')
    <section class="bg-pondok-accent py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div class="space-y-3">
                    <h1 class="text-4xl font-heading text-pondok-primary md:text-5xl">Blog Pesantren</h1>
                    <p class="text-sm text-gray-600 md:max-w-2xl">
                        Dokumentasi cerita perjalanan hafalan, kegiatan santri, kajian ilmiah, dan prestasi Pondok Pesantren
                        Nurul Ikhlas. Ikuti perkembangan terbaru untuk merasakan semangat keluarga besar pesantren.
                    </p>
                </div>
                <a href="{{ route('info') }}" class="btn-primary text-sm">Lihat Jadwal Kegiatan</a>
            </div>
        </div>
    </section>

    @if ($featured)
        @php
            $featuredThumbnail = $featured->thumbnail_url
                ?: 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1600&q=80';
        @endphp
        <section class="bg-white py-16">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <div class="grid gap-8 rounded-[2.5rem] border border-pondok-primary/10 bg-white p-8 shadow-soft lg:grid-cols-[1.2fr,1fr] lg:p-12">
                    <div class="space-y-6">
                        <span class="inline-flex items-center gap-2 rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary">
                            Sorotan Terbaru
                        </span>
                        <div class="space-y-2 text-xs text-gray-500">
                            <span>{{ $featured->formatted_date }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $featured->author }}</span>
                            <span class="mx-2">•</span>
                            <span>{{ $featured->reading_time }}</span>
                        </div>
                        <h2 class="text-3xl font-heading text-pondok-primary">{{ $featured->title }}</h2>
                        <p class="text-sm text-gray-600">{{ $featured->excerpt }}</p>
                        <a href="{{ route('blog.show', $featured) }}"
                            class="inline-flex items-center gap-2 text-sm font-semibold text-pondok-primary hover:text-pondok-secondary">
                            Baca Artikel
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                    </div>
                    <div class="relative aspect-[16/9] overflow-hidden rounded-3xl">
                        <img src="{{ $featuredThumbnail }}" alt="{{ $featured->title }}" class="absolute inset-0 h-full w-full object-cover">
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section class="bg-pondok-accent/40 py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-6 lg:flex-row">
                <aside class="lg:w-64">
                    <div class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-semibold text-pondok-primary">Kategori</h3>
                        <ul class="mt-4 space-y-3 text-sm text-gray-600">
                            @foreach ($categories as $category)
                                <li class="flex items-center justify-between rounded-xl bg-pondok-accent/60 px-4 py-3">
                                    <span>{{ $category['name'] }}</span>
                                    <span class="rounded-full bg-white px-2 py-0.5 text-xs font-semibold text-pondok-primary">
                                        {{ $category['count'] }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-6 rounded-3xl bg-pondok-primary p-6 text-sm text-white shadow-soft">
                        <p class="font-semibold">Ingin Berkontribusi?</p>
                        <p class="mt-2 text-pondok-accent/90">Kirim tulisan atau kabar kegiatan ke email humas kami.</p>
                        <a href="mailto:info@nurulikhlas.sch.id"
                            class="mt-4 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-pondok-accent">
                            Email Humas
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 9.75L21 12l-4.5 2.25M3 5.25h12a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25H3A2.25 2.25 0 01.75 16.5v-9A2.25 2.25 0 013 5.25z" />
                            </svg>
                        </a>
                    </div>
                </aside>
                <div class="flex-1">
                    <div class="grid gap-6 md:grid-cols-2">
                                                @foreach ($posts as $post)
                            @php
                                $thumbnail = $post->thumbnail_url
                                    ?: 'https://images.unsplash.com/photo-1464037866556-6812c9d1c72e?auto=format&fit=crop&w=800&q=80';
                            @endphp
                            <article class="flex h-full flex-col overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                                <div class="relative aspect-[4/3] overflow-hidden bg-pondok-accent">
                                    <img src="{{ $thumbnail }}" alt="{{ $post->title }}"
                                        class="absolute inset-0 h-full w-full object-cover transition duration-500 hover:scale-105">
                                    <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-pondok-primary">
                                        {{ $post->category }}
                                    </span>
                                </div>
                                <div class="flex flex-1 flex-col gap-3 p-6">
                                    <div class="text-xs text-gray-500">
                                        {{ $post->formatted_date }} &bull; {{ $post->reading_time }}
                                    </div>
                                    <h3 class="text-lg font-semibold text-pondok-primary">{{ $post->title }}</h3>
                                    <p class="text-sm text-gray-600">{{ $post->excerpt }}</p>
                                    <div class="mt-auto">
                                        <a href="{{ route('blog.show', $post) }}"
                                            class="inline-flex items-center gap-2 text-sm font-semibold text-pondok-primary hover:text-pondok-secondary">
                                            Baca Selengkapnya
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



