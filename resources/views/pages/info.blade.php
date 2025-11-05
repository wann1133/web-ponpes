@extends('layouts.app')

@section('title', 'Info Pesantren | Pondok Pesantren Nurul Ikhlas')
@section('meta_description', 'Informasi kegiatan, pengumuman terbaru, jadwal harian, dan kontak resmi Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas.')

@section('content')
    <section class="bg-gradient-to-br from-pondok-accent via-white to-pondok-accent py-20">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <span class="inline-flex items-center gap-2 rounded-full bg-pondok-primary/10 px-4 py-1 text-sm font-semibold text-pondok-primary">
                Informasi Terbaru
                <span class="h-1 w-1 rounded-full bg-pondok-primary/60"></span>
                {{ now()->translatedFormat('d F Y') }}
            </span>
            <div class="mt-6 flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                <div class="max-w-3xl space-y-4">
                    <h1 class="text-4xl font-heading text-pondok-primary md:text-5xl">
                        {{ $settings->hero_title ?? 'Kegiatan & Pengumuman Pondok Pesantren Nurul Ikhlas' }}
                    </h1>
                    <p class="text-base text-gray-600">
                        {{ $settings->hero_description ?? 'Jadwal rutin, program unggulan, serta informasi pendaftaran santri baru yang dirancang untuk mendukung perjalanan tahfidzul Qur\'an dan pembinaan karakter santri.' }}
                    </p>
                </div>
                @php $registrationUrl = $settings->registration_url ?? null; @endphp
                <a id="pendaftaran" href="{{ $registrationUrl ?: '#' }}" {{ $registrationUrl ? 'target="_blank"' : 'aria-disabled=true' }}
                    class="btn-primary w-fit text-sm {{ $registrationUrl ? '' : 'opacity-60 cursor-not-allowed' }}">
                    Form Pendaftaran Online
                </a>
            </div>
        </div>
    </section>

    <section id="program" class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Program & Kegiatan Unggulan</h2>
                    <p class="text-sm text-gray-600">Aktivitas harian dan pekanan yang membentuk kebiasaan Qur’ani.</p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                @foreach ($activities as $activity)
                    <div class="flex flex-col justify-between rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                        <div class="space-y-3">
                            <span class="inline-flex items-center gap-2 rounded-full bg-pondok-accent px-3 py-1 text-xs font-semibold text-pondok-primary">
                                Kegiatan Pesantren
                            </span>
                            <h3 class="text-xl font-semibold text-pondok-primary">{{ $activity->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $activity->description }}</p>
                        </div>
                        <div class="mt-6 flex items-center gap-2 text-sm font-medium text-pondok-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 3v1.5M15.75 3v1.5m-9 3.75h12m-13.5 9V7.5a2.25 2.25 0 012.25-2.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9A2.25 2.25 0 015.25 16.5z" />
                            </svg>
                            {{ $activity->schedule ?? 'Jadwal menyusul' }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-pondok-accent/60 py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Pengumuman Pesantren</h2>
                    <p class="text-sm text-gray-600">Kabar terbaru untuk santri, wali santri, dan masyarakat.</p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                @foreach ($announcements as $announcement)
                    <article class="flex h-full flex-col justify-between rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow-sm">
                        <div class="space-y-4">
                            <span class="inline-flex items-center gap-2 rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary">
                                {{ $announcement->type ?? 'Informasi' }}
                            </span>
                            <h3 class="text-xl font-semibold text-pondok-primary">{{ $announcement->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $announcement->summary }}</p>
                        </div>
                        <div class="mt-6 text-xs font-medium text-gray-500">
                            Diterbitkan pada {{ $announcement->formattedDate() ?? '-' }}
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Jadwal Harian Santri</h2>
                    <p class="text-sm text-gray-600">Rutinitas yang teratur menjaga hafalan dan produktivitas santri.</p>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-3xl border border-pondok-primary/10 bg-pondok-accent/40 shadow-sm">
                <ul class="divide-y divide-pondok-primary/10">
                    @foreach ($dailySchedule as $item)
                        <li class="grid gap-4 px-6 py-4 text-sm text-gray-600 md:grid-cols-[100px,1fr] md:px-10">
                            <div class="font-semibold text-pondok-primary">{{ $item->time }}</div>
                            <div>{{ $item->activity }}</div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    <section id="contact" class="bg-gradient-to-br from-pondok-primary to-pondok-secondary py-16 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-[1.3fr,1fr] lg:px-10">
            <div class="space-y-5">
                <h2 class="text-3xl font-heading md:text-4xl">Hubungi & Kunjungi Kami</h2>
                <p class="text-sm text-pondok-accent/90">
                    Kami siap membantu menjawab pertanyaan seputar program, biaya pendidikan, fasilitas, maupun proses
                    pendaftaran santri baru. Silakan hubungi kami melalui kanal berikut atau datang langsung ke pesantren.
                </p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl bg-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-pondok-accent/80">Telepon</p>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings->phone ?? '') }}"
                            class="mt-2 block text-lg font-semibold text-white hover:text-pondok-accent">
                            {{ $settings->phone ?? '-' }}
                        </a>
                        <p class="mt-3 text-xs text-pondok-accent/70">Admin pesantren aktif 08.00 - 16.00 WIB</p>
                    </div>
                    <div class="rounded-2xl bg-white/10 p-5">
                        <p class="text-xs uppercase tracking-wide text-pondok-accent/80">Email</p>
                        <a href="mailto:{{ $settings->email ?? '' }}"
                            class="mt-2 block text-lg font-semibold text-white hover:text-pondok-accent">
                            {{ $settings->email ?? '-' }}
                        </a>
                        <p class="mt-3 text-xs text-pondok-accent/70">Respon maksimal 1x24 jam kerja</p>
                    </div>
                </div>
                <div class="rounded-2xl bg-white/10 p-5 text-sm text-pondok-accent">
                    <p class="font-semibold text-white">Alamat Pesantren</p>
                    <p class="mt-2 leading-relaxed text-pondok-accent/90">{{ $settings->address ?? '-' }}</p>
                    <a href="{{ $settings->maps_url ?? '#' }}" target="_blank"
                        class="mt-3 inline-flex items-center gap-2 text-sm font-semibold text-white hover:text-pondok-accent">
                        Lihat di Google Maps
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12l-3.75 3.75M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-[2.5rem] bg-white p-8 text-gray-700 shadow-soft">
                    <h3 class="text-lg font-semibold text-pondok-primary">Pertanyaan yang Sering Diajukan</h3>
                    <div class="mt-6 space-y-4">
                        @foreach ($faq as $item)
                            <div class="rounded-2xl border border-pondok-primary/10 bg-pondok-accent/40 p-4">
                                <p class="text-sm font-semibold text-pondok-primary">{{ $item->question }}</p>
                                <p class="mt-2 text-sm text-gray-600">{{ $item->answer }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


