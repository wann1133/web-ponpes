@extends('layouts.app')

@section('title', 'Pendaftaran Santri | Nurul Ikhlas')

@section('content')
    @php
        $options = [
            [
                'jenjang' => 'smp',
                'title' => 'Daftar SMP',
                'excerpt' => 'Program jenjang SMP dengan kurikulum diniyah dan akademik terpadu.',
            ],
            [
                'jenjang' => 'sma',
                'title' => 'Daftar SMA',
                'excerpt' => 'Program jenjang SMA dengan fokus tahfidz, akademik, dan kepemimpinan.',
            ],
        ];
    @endphp

    <section class="bg-gradient-to-b from-pondok-accent/40 to-white">
        <div class="mx-auto max-w-5xl px-6 py-12 lg:px-8 lg:py-16">
            <div class="text-center">
                <span class="inline-flex items-center rounded-full bg-pondok-primary/10 px-4 py-1 text-xs font-semibold uppercase tracking-wide text-pondok-primary">
                    Pendaftaran Santri Baru
                </span>
                <h1 class="mt-4 text-3xl font-semibold text-pondok-primary sm:text-4xl">Pilih Jenjang Pendidikan</h1>
                <p class="mt-3 text-base text-gray-600">
                    Silakan tentukan jenjang pendidikan terlebih dahulu sebelum mengisi formulir pendaftaran.
                </p>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2">
                @foreach ($options as $option)
                    <a
                        href="{{ route('pendaftaran.create', $option['jenjang']) }}"
                        class="group relative overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white p-8 shadow transition duration-200 hover:-translate-y-1 hover:shadow-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-pondok-primary/50"
                    >
                        <div class="absolute -top-16 right-6 h-40 w-40 rounded-full bg-pondok-primary/10 blur-2xl transition duration-200 group-hover:bg-pondok-primary/20"></div>
                        <div class="relative">
                            <span class="inline-flex items-center rounded-full bg-pondok-secondary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-pondok-secondary">
                                Jenjang {{ strtoupper($option['jenjang']) }}
                            </span>
                            <h2 class="mt-5 text-2xl font-semibold text-pondok-primary">{{ $option['title'] }}</h2>
                            <p class="mt-3 text-sm text-gray-600">
                                {{ $option['excerpt'] }}
                            </p>
                            <div class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-pondok-primary">
                                Lanjutkan ke formulir
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 12l-6.75 6.75m6.75-6.75L10.5 5.25m6.75 6.75H3" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
