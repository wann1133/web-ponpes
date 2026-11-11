@extends('layouts.app')

@section('title', 'Info Pesantren | Pondok Pesantren Nurul Ikhlas')
@section('meta_description', 'Informasi kegiatan, pengumuman terbaru, jadwal harian, dan kontak resmi Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas.')

@section('content')
    @php
        $brochures = $settings->resolved_brochures;
        $hasBrochures = count($brochures) > 0;
        $registrationHref = $settings->effective_registration_url;
        $registrationPeriods = $settings->resolved_registration_periods;
        $registrationRequirements = $settings->resolved_registration_requirements;
        $registrationProcedures = $settings->resolved_registration_procedures;
        $registrationContacts = $settings->resolved_registration_contacts;
    @endphp

    @if ($hasBrochures)
        <x-image-lightbox
            id="brosur-psb"
            :photos="$brochures"
            title="Brosur Resmi Pendaftaran Santri Baru"
            subtitle="Ketuk panah atau geser untuk melihat halaman lainnya"
            item-label="Brosur"
            :downloadable="true"
            :cta-url="$registrationHref"
            :cta-label="$settings->effective_registration_button_label"
        />
    @endif

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
                <div class="flex flex-wrap items-center gap-3">
                    @if ($hasBrochures)
                        <a href="#brosur"
                            class="btn-secondary w-fit bg-white/90 text-sm">
                            Lihat Brosur
                        </a>
                    @endif
                    <a id="pendaftaran" href="{{ $registrationHref }}"
                        class="btn-primary w-fit text-sm">
                        {{ $settings->effective_registration_button_label }}
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16">
        <div class="mx-auto max-w-7xl px-6 lg:px-10">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="section-heading">Program Pendidikan & Fasilitas</h2>
                    <p class="text-sm text-gray-600">
                        Gambaran ringkas jenjang pendidikan, program unggulan, serta fasilitas yang disiapkan Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas.
                    </p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <div class="rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="flex items-center gap-2 text-pondok-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-wide">Program Pendidikan</span>
                    </div>
                    <h3 class="mt-4 text-2xl font-semibold text-pondok-primary">Membentuk Generasi Qur'ani</h3>
                    <ul class="mt-6 space-y-3 text-sm text-gray-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-pondok-accent text-pondok-primary">1</span>
                            SMP Islam Nurul Ikhlas
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-pondok-accent text-pondok-primary">2</span>
                            SMA Nurul Ikhlas
                        </li>
                    </ul>
                </div>

                <div class="rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="flex items-center gap-2 text-pondok-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.5-2 4-2 5.5 0A3.5 3.5 0 0112 15.5v2.75M12 8c-1.5-2-4-2-5.5 0A3.5 3.5 0 0012 15.5v2.75" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-wide">Program Unggulan</span>
                    </div>
                    <h3 class="mt-4 text-2xl font-semibold text-pondok-primary">Pembinaan Karakter Qur'ani</h3>
                    <ul class="mt-6 space-y-3 text-sm text-gray-600">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-2 w-2 rounded-full bg-pondok-primary"></span>
                            Tahfidzul Qur'an
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-2 w-2 rounded-full bg-pondok-primary"></span>
                            Seni membaca Al-Qur'an
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-2 w-2 rounded-full bg-pondok-primary"></span>
                            Belajar Kitab Kuning
                        </li>
                    </ul>
                    
                </div>

                <div class="rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-soft">
                    <div class="flex items-center gap-2 text-pondok-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7.5l9-4.5 9 4.5-9 4.5L3 7.5zm0 9l9 4.5 9-4.5m-9-4.5l9 4.5M12 7.5V3" />
                        </svg>
                        <span class="text-sm font-semibold uppercase tracking-wide">Fasilitas Pesantren</span>
                    </div>
                    <h3 class="mt-4 text-2xl font-semibold text-pondok-primary">Lingkungan Belajar Nyaman</h3>
                    <ul class="mt-6 grid gap-2 text-sm text-gray-600 sm:grid-cols-2">
                        <li class="flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Gedung asrama
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Lapangan olahraga
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Jaringan Wi-Fi / internet
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Koperasi pesantren
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Majelis putera & puteri
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Bus pesantren
                        </li>
                        <li class="flex items-center gap-2 sm:col-span-2">
                            <span class="inline-block h-1.5 w-1.5 rounded-full bg-pondok-primary"></span>
                            Kantin santri
                        </li>
                    </ul>
                </div>
            </div>

            <div class="mt-10 grid gap-6 lg:grid-cols-[1fr_1.2fr]">
                <div class="flex flex-col justify-between rounded-3xl border border-pondok-primary/10 bg-gradient-to-br from-pondok-primary to-pondok-secondary p-8 text-white shadow-soft">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-white/70">
                            Biaya Pendaftaran
                        </span>
                        <h3 class="mt-4 text-4xl font-heading text-white">{{ $settings->effective_registration_fee }}</h3>
                        <p class="mt-3 text-sm text-white/85">
                            {{ $settings->effective_registration_fee_note }}
                        </p>
                    </div>
                    <div class="mt-6 space-y-2">
                        <p class="text-xs uppercase tracking-wide text-white/70">{{ $settings->effective_registration_cta_title }}</p>
                        <p class="text-sm text-white/85">
                            {{ $settings->effective_registration_cta_description }}
                        </p>
                        <a href="{{ $registrationHref }}"
                            class="inline-flex w-full items-center justify-center rounded-full bg-white/90 px-4 py-2.5 text-sm font-semibold text-pondok-primary transition hover:bg-white">
                            {{ $settings->effective_registration_button_label }}
                        </a>
                    </div>
                </div>

                <div class="rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow-sm">
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="space-y-3">
                            <span class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Periode Pendaftaran</span>
                            <ul class="space-y-2 text-sm text-gray-600">
                                @forelse ($registrationPeriods as $period)
                                    <li>
                                        <span class="font-semibold text-pondok-primary">{{ $period['name'] }}</span><br>
                                        {{ $period['date'] }}
                                    </li>
                                @empty
                                    <li class="text-gray-400">Informasi gelombang akan segera diumumkan.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="space-y-3">
                            <span class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Syarat Pendaftaran</span>
                            <ul class="space-y-2 text-sm text-gray-600">
                                @forelse ($registrationRequirements as $requirement)
                                    <li>{{ $requirement }}</li>
                                @empty
                                    <li class="text-gray-400">Belum ada persyaratan tertulis.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <div class="space-y-3">
                            <span class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Teknis Pendaftaran</span>
                            <ul class="space-y-2 text-sm text-gray-600">
                                @forelse ($registrationProcedures as $procedure)
                                    <li>
                                        <span class="font-semibold text-pondok-primary">{{ $procedure['title'] }}</span><br>
                                        {{ $procedure['description'] }}
                                    </li>
                                @empty
                                    <li class="text-gray-400">Hubungi panitia pendaftaran untuk detail teknis.</li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="space-y-3">
                            <span class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Informasi Kontak</span>
                            <ul class="space-y-2 text-sm text-gray-600">
                                @forelse ($registrationContacts as $contact)
                                    @php
                                        $digits = preg_replace('/[^0-9]/', '', $contact['phone']);
                                        $telHref = str_starts_with($digits, '0')
                                            ? '+62'.substr($digits, 1)
                                            : (str_starts_with($digits, '62') ? '+'.$digits : $digits);
                                    @endphp
                                    <li>
                                        <span class="font-semibold text-pondok-primary">{{ $contact['name'] }}</span><br>
                                        @if ($digits !== '')
                                            <a href="tel:{{ $telHref }}" class="text-pondok-primary hover:text-pondok-secondary">{{ $contact['phone'] }}</a>
                                        @else
                                            <span>{{ $contact['phone'] }}</span>
                                        @endif
                                    </li>
                                @empty
                                    <li class="text-gray-400">Belum ada kontak panitia.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if ($hasBrochures)
                <div id="brosur" class="mt-10 rounded-3xl border border-pondok-primary/10 bg-pondok-accent/50 p-6 sm:p-8">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h3 class="text-2xl font-semibold text-pondok-primary">Brosur Pendaftaran Santri Baru</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                Ketuk brosur untuk memperbesar tampilan dan membaca rincian biaya secara jelas, atau unduh langsung ke perangkat Anda.
                            </p>
                        </div>
                        <span class="inline-flex w-fit items-center rounded-full bg-white px-3.5 py-1 text-xs font-semibold text-pondok-primary shadow-sm">
                            {{ count($brochures) }} halaman brosur
                        </span>
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        @foreach ($brochures as $index => $brochure)
                            <div class="group overflow-hidden rounded-2xl border border-pondok-primary/10 bg-white p-3 shadow-sm transition hover:-translate-y-0.5 hover:shadow-soft">
                                <button
                                    type="button"
                                    x-data
                                    x-on:click="$dispatch('open-image-lightbox', { id: 'brosur-psb', index: {{ $index }} })"
                                    aria-label="Perbesar {{ $brochure['label'] }}"
                                    class="relative block w-full overflow-hidden rounded-xl bg-pondok-accent focus:outline-none focus:ring-2 focus:ring-pondok-primary"
                                >
                                    <img
                                        src="{{ $brochure['url'] }}"
                                        alt="{{ $brochure['label'] }}"
                                        loading="lazy"
                                        class="h-auto w-full object-contain transition duration-300 group-hover:scale-[1.02]"
                                    >
                                    <span class="absolute bottom-3 right-3 inline-flex items-center gap-1.5 rounded-full bg-slate-900/75 px-3 py-1 text-xs font-semibold text-white backdrop-blur-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                                        </svg>
                                        Perbesar
                                    </span>
                                </button>
                                <div class="mt-3 flex items-center justify-between px-1">
                                    <span class="text-xs font-semibold text-pondok-primary">{{ $brochure['label'] }}</span>
                                    <a
                                        href="{{ $brochure['url'] }}"
                                        download
                                        target="_blank"
                                        rel="noopener"
                                        class="inline-flex items-center gap-1 text-xs font-semibold text-slate-600 transition hover:text-pondok-primary"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                        Unduh
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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
                <h2 class="text-3xl font-heading text-white md:text-4xl">Hubungi & Kunjungi Kami</h2>
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
