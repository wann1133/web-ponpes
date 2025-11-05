@extends('layouts.app')

@section('title', $post->title.' | Blog Pesantren Nurul Ikhlas')
@section('meta_description', $post->excerpt ?? 'Artikel terbaru Pondok Pesantren Nurul Ikhlas.')
@section('og_title', $post->title.' | Blog Pesantren Nurul Ikhlas')
@section('og_description', $post->excerpt ?? 'Artikel terbaru Pondok Pesantren Nurul Ikhlas.')

@section('content')
    @php
        $heroImage = $post->thumbnail_url
            ?: 'https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1600&q=80';
        $bodyHtml = $post->body ? nl2br(e($post->body)) : null;
    @endphp

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
                            <span class="absolute left-4 top-4 rounded-full bg-white/90 px-3 py-1 text-xs font-semibold text-pondok-primary">
                                {{ $item->category }}
                            </span>
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

