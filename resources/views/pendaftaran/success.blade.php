@extends('layouts.app')

@section('title', 'Pendaftaran Berhasil | Nurul Ikhlas')

@section('content')
    @php
        $jenjangLabel = $jenjang ? strtoupper($jenjang) : null;
    @endphp

    <section class="bg-gradient-to-b from-pondok-accent/40 to-white">
        <div class="mx-auto max-w-3xl px-6 py-16 text-center lg:px-8">
            <div class="rounded-3xl border border-pondok-primary/20 bg-white/95 p-10 shadow-xl backdrop-blur">
                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-pondok-primary/10 text-pondok-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="mt-6 text-3xl font-semibold text-pondok-primary">Terima kasih!</h1>
                <p class="mt-3 text-sm text-gray-600">
                    Formulir pendaftaran {{ $jenjangLabel ? 'jenjang ' . $jenjangLabel : 'santri' }} telah kami terima.
                    Tim penerimaan santri baru akan menghubungi Anda melalui WhatsApp atau email untuk proses selanjutnya.
                </p>
                <div class="mt-8 flex flex-col items-center justify-center gap-3 sm:flex-row">
                    <a
                        href="{{ route('pendaftaran.index') }}"
                        class="inline-flex items-center gap-2 rounded-full border border-pondok-primary px-5 py-2.5 text-sm font-semibold text-pondok-primary transition duration-200 hover:bg-pondok-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-pondok-primary/60"
                    >
                        Daftarkan Jenjang Lain
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12l7.5-7.5M3 12h18" />
                        </svg>
                    </a>
                    <a
                        href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-pondok-primary px-5 py-2.5 text-sm font-semibold text-white transition duration-200 hover:bg-pondok-secondary focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-pondok-primary"
                    >
                        Kembali ke Beranda
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
