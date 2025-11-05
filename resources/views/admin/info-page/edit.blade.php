@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Info | Panel Admin')
@section('page_title', 'Pengaturan Halaman Info Pesantren')

@section('content')
    <form action="{{ route('admin.info-page.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-pondok-primary">Bagian Hero</h2>
            <p class="text-xs text-slate-500">Atur judul dan deskripsi utama halaman info pesantren.</p>

            <div class="mt-4 space-y-5">
                <div>
                    <label for="hero_title" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Judul Hero
                    </label>
                    <input type="text" id="hero_title" name="hero_title"
                        value="{{ old('hero_title', $settings->hero_title) }}"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                </div>

                <div>
                    <label for="hero_description" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Deskripsi Hero
                    </label>
                    <textarea id="hero_description" name="hero_description" rows="3"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('hero_description', $settings->hero_description) }}</textarea>
                </div>

                <div>
                    <label for="registration_url" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        URL Form Pendaftaran
                    </label>
                    <input type="url" id="registration_url" name="registration_url"
                        value="{{ old('registration_url', $settings->registration_url) }}"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                        placeholder="https://">
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-pondok-primary">Kontak & Lokasi</h2>
            <p class="text-xs text-slate-500">Informasi kontak yang ditampilkan pada halaman info.</p>

            <div class="mt-4 grid gap-5 md:grid-cols-2">
                <div>
                    <label for="phone" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Nomor Telepon
                    </label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $settings->phone) }}"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                        placeholder="+62 ...">
                </div>
                <div>
                    <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email', $settings->email) }}"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                </div>
            </div>

            <div class="mt-4">
                <label for="address" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Alamat
                </label>
                <textarea id="address" name="address" rows="3"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('address', $settings->address) }}</textarea>
            </div>

            <div class="mt-4">
                <label for="maps_url" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    URL Google Maps
                </label>
                <input type="url" id="maps_url" name="maps_url" value="{{ old('maps_url', $settings->maps_url) }}"
                    class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                    placeholder="https://maps.google.com/">
            </div>
        </section>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Simpan Pengaturan
            </button>
        </div>
    </form>
@endsection
