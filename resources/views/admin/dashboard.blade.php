@extends('layouts.admin')

@section('title', 'Dashboard | Panel Admin')
@section('page_title', 'Ringkasan Konten')

@section('content')
    <div class="grid gap-6 lg:grid-cols-3">
        @php
            $statCards = [
                ['label' => 'Program & Kegiatan', 'value' => $stats['activities'], 'route' => 'admin.activities.index'],
                ['label' => 'Pengumuman Aktif', 'value' => $stats['announcements'], 'route' => 'admin.announcements.index'],
                ['label' => 'Jadwal Harian', 'value' => $stats['daily_schedules'], 'route' => 'admin.daily-schedules.index'],
                ['label' => 'FAQ', 'value' => $stats['faqs'], 'route' => 'admin.faqs.index'],
                ['label' => 'Artikel Blog', 'value' => $stats['blog_posts'], 'route' => 'admin.blog-posts.index'],
                ['label' => 'Pengaturan Info', 'value' => $stats['has_settings'] ? 'Siap' : 'Belum', 'route' => 'admin.info-page.edit'],
            ];
        @endphp

        @foreach ($statCards as $card)
            <a href="{{ route($card['route']) }}"
                class="flex flex-col justify-between rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary/70">{{ $card['label'] }}</p>
                    <p class="mt-3 text-3xl font-heading text-pondok-primary">{{ $card['value'] }}</p>
                </div>
                <span class="mt-4 inline-flex items-center gap-2 text-xs font-semibold text-pondok-primary">
                    Kelola
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                    </svg>
                </span>
            </a>
        @endforeach
    </div>

    <div class="mt-10 grid gap-6 lg:grid-cols-2">
        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <header class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-pondok-primary">Artikel Blog Terbaru</h2>
                <a href="{{ route('admin.blog-posts.index') }}" class="text-xs font-semibold text-pondok-primary hover:text-pondok-secondary">
                    Lihat semua
                </a>
            </header>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                @forelse ($recentPosts as $post)
                    <li class="rounded-2xl border border-transparent px-3 py-2 transition hover:border-pondok-primary/20 hover:bg-pondok-accent/40">
                        <p class="font-medium text-pondok-primary">{{ $post->title }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $post->formatted_date }} &bull; {{ $post->category ?? 'Tanpa kategori' }}
                        </p>
                    </li>
                @empty
                    <li class="rounded-2xl bg-pondok-accent/50 px-3 py-4 text-center text-xs text-slate-500">
                        Belum ada artikel.
                    </li>
                @endforelse
            </ul>
        </section>

        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <header class="flex items-center justify-between">
                <h2 class="text-sm font-semibold text-pondok-primary">Pengumuman Terbaru</h2>
                <a href="{{ route('admin.announcements.index') }}"
                    class="text-xs font-semibold text-pondok-primary hover:text-pondok-secondary">
                    Kelola
                </a>
            </header>
            <ul class="mt-4 space-y-3 text-sm text-slate-600">
                @forelse ($recentAnnouncements as $announcement)
                    <li class="rounded-2xl border border-transparent px-3 py-2 transition hover:border-pondok-primary/20 hover:bg-pondok-accent/40">
                        <p class="font-medium text-pondok-primary">{{ $announcement->title }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $announcement->formattedDate() ?? '-' }} &bull; {{ $announcement->type ?? 'Informasi' }}
                        </p>
                    </li>
                @empty
                    <li class="rounded-2xl bg-pondok-accent/50 px-3 py-4 text-center text-xs text-slate-500">
                        Belum ada pengumuman aktif.
                    </li>
                @endforelse
            </ul>
        </section>
    </div>
@endsection
