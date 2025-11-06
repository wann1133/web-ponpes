@extends('layouts.app')

@section('title', 'Form Pendaftaran ' . strtoupper($jenjang) . ' | Nurul Ikhlas')

@section('content')
    @php
        $label = strtoupper($jenjang);
    @endphp

    <section class="bg-gradient-to-b from-white to-pondok-accent/30">
        <div class="mx-auto max-w-4xl px-6 py-12 lg:px-8 lg:py-16">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="inline-flex items-center rounded-full bg-pondok-secondary/10 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-pondok-secondary">
                        Jenjang {{ $label }}
                    </span>
                    <h1 class="mt-3 text-3xl font-semibold text-pondok-primary sm:text-4xl">
                        Formulir Pendaftaran Santri Baru
                    </h1>
                    <p class="mt-2 text-sm text-gray-600">
                        Lengkapi data calon santri dengan benar. Petugas kami akan menghubungi Anda setelah berkas diverifikasi.
                    </p>
                </div>
                <a
                    href="{{ route('pendaftaran.index') }}"
                    class="inline-flex items-center gap-2 rounded-full border border-pondok-primary px-4 py-2 text-sm font-semibold text-pondok-primary transition duration-200 hover:bg-pondok-primary hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-pondok-primary/60"
                >
                    Pilih Jenjang Lain
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12l7.5-7.5M3 12h18" />
                    </svg>
                </a>
            </div>

            @if ($errors->any())
                <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                    <p class="font-semibold">Periksa kembali data Anda:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                action="{{ route('pendaftaran.store', $jenjang) }}"
                method="POST"
                enctype="multipart/form-data"
                class="mt-8 rounded-3xl border border-white/60 bg-white/95 p-8 shadow-lg backdrop-blur"
            >
                @csrf

                <div class="grid gap-6 md:grid-cols-2">
                    <div class="md:col-span-2">
                        <label for="nama_lengkap" class="block text-sm font-semibold text-gray-700">
                            Nama Lengkap *
                        </label>
                        <input
                            type="text"
                            name="nama_lengkap"
                            id="nama_lengkap"
                            value="{{ old('nama_lengkap') }}"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="jenis_kelamin" class="block text-sm font-semibold text-gray-700">
                            Jenis Kelamin *
                        </label>
                        <select
                            name="jenis_kelamin"
                            id="jenis_kelamin"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                            <option value="" disabled {{ old('jenis_kelamin') === null ? 'selected' : '' }}>Pilih</option>
                            <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div>
                        <label for="nisn" class="block text-sm font-semibold text-gray-700">
                            NISN
                        </label>
                        <input
                            type="text"
                            name="nisn"
                            id="nisn"
                            value="{{ old('nisn') }}"
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="tempat_lahir" class="block text-sm font-semibold text-gray-700">
                            Tempat Lahir *
                        </label>
                        <input
                            type="text"
                            name="tempat_lahir"
                            id="tempat_lahir"
                            value="{{ old('tempat_lahir') }}"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="tanggal_lahir" class="block text-sm font-semibold text-gray-700">
                            Tanggal Lahir *
                        </label>
                        <input
                            type="date"
                            name="tanggal_lahir"
                            id="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div class="md:col-span-2">
                        <label for="alamat" class="block text-sm font-semibold text-gray-700">
                            Alamat Lengkap *
                        </label>
                        <textarea
                            name="alamat"
                            id="alamat"
                            rows="3"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >{{ old('alamat') }}</textarea>
                    </div>

                    <div>
                        <label for="asal_sekolah" class="block text-sm font-semibold text-gray-700">
                            Asal Sekolah *
                        </label>
                        <input
                            type="text"
                            name="asal_sekolah"
                            id="asal_sekolah"
                            value="{{ old('asal_sekolah') }}"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="nama_ayah" class="block text-sm font-semibold text-gray-700">
                            Nama Ayah *
                        </label>
                        <input
                            type="text"
                            name="nama_ayah"
                            id="nama_ayah"
                            value="{{ old('nama_ayah') }}"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="nama_ibu" class="block text-sm font-semibold text-gray-700">
                            Nama Ibu *
                        </label>
                        <input
                            type="text"
                            name="nama_ibu"
                            id="nama_ibu"
                            value="{{ old('nama_ibu') }}"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="no_wa" class="block text-sm font-semibold text-gray-700">
                            Nomor WhatsApp Aktif *
                        </label>
                        <input
                            type="text"
                            name="no_wa"
                            id="no_wa"
                            value="{{ old('no_wa') }}"
                            placeholder="+62812xxxxxxx"
                            required
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            class="mt-2 w-full rounded-2xl border border-gray-200 px-4 py-3 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        >
                    </div>

                    <div>
                        <label for="berkas_akta" class="block text-sm font-semibold text-gray-700">
                            Akta Kelahiran (PDF/JPG, maks. 2MB)
                        </label>
                        <input
                            type="file"
                            name="berkas_akta"
                            id="berkas_akta"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="mt-2 block w-full text-sm text-gray-600 file:mr-4 file:rounded-full file:border-0 file:bg-pondok-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-pondok-secondary"
                        >
                    </div>

                    <div>
                        <label for="berkas_kk" class="block text-sm font-semibold text-gray-700">
                            Kartu Keluarga (PDF/JPG, maks. 2MB)
                        </label>
                        <input
                            type="file"
                            name="berkas_kk"
                            id="berkas_kk"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="mt-2 block w-full text-sm text-gray-600 file:mr-4 file:rounded-full file:border-0 file:bg-pondok-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-pondok-secondary"
                        >
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-xs text-gray-500">
                        Dengan mengirim formulir ini Anda menyetujui bahwa data yang dimasukkan adalah benar.
                    </p>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-pondok-primary px-6 py-3 text-sm font-semibold text-white shadow-lg transition duration-200 hover:bg-pondok-secondary focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-pondok-primary"
                    >
                        Kirim Pendaftaran
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12l-7.5 7.5M21 12H3" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
