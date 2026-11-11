@extends('layouts.admin')

@section('title', 'Pengaturan Halaman Info | Panel Admin')
@section('page_title', 'Pengaturan Halaman Info, Brosur & Pendaftaran')

@php
    $existingBrochures = collect($settings->resolved_brochures)
        ->map(fn ($item) => [
            'path' => $item['path'],
            'url' => $item['url'],
            'markedDelete' => false,
        ])
        ->values()
        ->all();

    $initialPeriods = old('registration_periods', $settings->resolved_registration_periods);
    $initialRequirements = old('registration_requirements', $settings->resolved_registration_requirements);
    $initialProcedures = old('registration_procedures', $settings->resolved_registration_procedures);
    $initialContacts = old('registration_contacts', $settings->resolved_registration_contacts);
    $effectiveRegUrlValue = old(
        'registration_url',
        $settings->registration_url === 'https://forms.gle/xxxxxx' ? '' : $settings->registration_url
    );
@endphp

@section('content')
    <form action="{{ route('admin.info-page.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- 1. Banner Pop-up Awal Website (Beranda) --}}
        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="text-sm font-semibold text-pondok-primary">1. Banner Pop-up Awal (Beranda)</h2>
                    <p class="text-xs text-slate-500">Banner yang langsung tampil saat pengunjung membuka halaman Beranda.</p>
                </div>
                <label class="inline-flex items-center gap-2 rounded-full bg-pondok-accent px-4 py-2 text-xs font-semibold text-pondok-primary">
                    <input type="checkbox" name="promo_is_active" value="1"
                        class="h-4 w-4 rounded border-pondok-primary text-pondok-primary focus:ring-pondok-primary"
                        @checked(old('promo_is_active', $settings->promo_is_active ?? true))>
                    Tampilkan pop-up saat Beranda dibuka
                </label>
            </div>

            <div class="mt-5 grid gap-6 md:grid-cols-[200px,1fr]">
                <div class="space-y-2">
                    <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">Preview Banner Aktif</p>
                    @if ($settings->promo_banner_url)
                        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 p-2">
                            <img src="{{ $settings->promo_banner_url }}" alt="Banner Pop-up Aktif"
                                class="mx-auto max-h-60 w-auto rounded-xl object-contain">
                        </div>
                    @endif
                    @if ($settings->has_custom_promo_banner)
                        <label class="flex items-center gap-2 text-xs font-semibold text-red-500">
                            <input type="checkbox" name="reset_promo_banner" value="1"
                                class="h-4 w-4 rounded border-red-300 text-red-500 focus:ring-red-400">
                            Kembalikan ke banner default
                        </label>
                    @endif
                </div>

                <div class="space-y-4">
                    <div>
                        <label for="promo_banner" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Ganti Gambar Banner Pop-up
                        </label>
                        <input type="file" id="promo_banner" name="promo_banner" accept="image/jpeg,image/png,image/webp,image/*"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-pondok-primary focus:ring-pondok-primary">
                        <p class="mt-1 text-[11px] text-slate-400">
                            Format JPG/PNG/WebP (disarankan ukuran portrait/tegak). Foto otomatis dikompres agar cepat dibuka di HP.
                        </p>
                    </div>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div>
                            <label for="promo_link_url" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Tautan Tombol &ldquo;Daftar Sekarang&rdquo;
                            </label>
                            <input type="text" id="promo_link_url" name="promo_link_url"
                                value="{{ old('promo_link_url', $settings->promo_link_url) }}"
                                placeholder="/pendaftaran (otomatis jika dikosongkan)"
                                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                        </div>
                        <div>
                            <label for="promo_auto_close_seconds" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Auto-Tutup Pop-up (Detik)
                            </label>
                            <input type="number" id="promo_auto_close_seconds" name="promo_auto_close_seconds"
                                min="0" max="120"
                                value="{{ old('promo_auto_close_seconds', $settings->promo_auto_close_seconds ?? 0) }}"
                                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                            <p class="mt-1 text-[11px] text-slate-400">Isi 0 agar tidak menutup otomatis (pengunjung tutup manual).</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. Brosur Pendaftaran (Multi-Halaman: Depan & Belakang) --}}
        <section
            x-data="promoBrochuresAdmin(@js($existingBrochures))"
            x-init="init()"
            class="space-y-4 rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm"
        >
            <input type="hidden" name="brochure_form_present" value="1">

            <div class="flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 class="text-sm font-semibold text-pondok-primary">2. Brosur Resmi Pendaftaran (Depan / Belakang)</h2>
                    <p class="text-xs text-slate-500">
                        Brosur ini tetap bisa dilihat, diperbesar, dan diunduh pengunjung lewat tombol &ldquo;Lihat Brosur&rdquo; di Beranda &amp; halaman Info Pesantren.
                    </p>
                </div>
                <span
                    x-show="totalActiveCount > 0"
                    x-cloak
                    class="rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary"
                    x-text="`${totalActiveCount} halaman`"
                ></span>
            </div>

            <template x-if="existingBrochures.length > 0">
                <div class="space-y-2">
                    <p class="text-xs font-semibold text-slate-600">Halaman Brosur Aktif</p>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        <template x-for="(item, index) in existingBrochures" :key="item.path">
                            <div
                                class="relative overflow-hidden rounded-2xl border bg-slate-50 p-2.5 transition"
                                :class="item.markedDelete ? 'border-red-300 bg-red-50/70 opacity-60' : 'border-slate-200'"
                            >
                                <input type="hidden" name="existing_brochures[]" :value="item.path">
                                <template x-if="item.markedDelete">
                                    <input type="hidden" name="delete_brochures[]" :value="item.path">
                                </template>

                                <div class="relative aspect-[16/11] overflow-hidden rounded-xl bg-white">
                                    <img :src="item.url" :alt="`Brosur Halaman ${index + 1}`" class="h-full w-full object-contain">
                                    <span
                                        class="absolute left-2 top-2 rounded-full bg-black/70 px-2.5 py-0.5 text-[11px] font-semibold text-white"
                                        x-text="`Halaman ${index + 1}`"
                                    ></span>
                                    <template x-if="item.markedDelete">
                                        <span class="absolute inset-0 flex items-center justify-center bg-red-900/50 text-xs font-semibold text-white">
                                            Akan dihapus
                                        </span>
                                    </template>
                                </div>

                                <div class="mt-2 flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-1">
                                        <button type="button" x-on:click="moveExisting(index, -1)" :disabled="index === 0"
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-xs text-slate-600 hover:bg-slate-100 disabled:opacity-35">&larr;</button>
                                        <button type="button" x-on:click="moveExisting(index, 1)" :disabled="index === existingBrochures.length - 1"
                                            class="inline-flex h-7 w-7 items-center justify-center rounded-lg border border-slate-200 bg-white text-xs text-slate-600 hover:bg-slate-100 disabled:opacity-35">&rarr;</button>
                                    </div>
                                    <button
                                        type="button"
                                        x-on:click="item.markedDelete = !item.markedDelete"
                                        class="rounded-lg px-2.5 py-1 text-xs font-semibold transition"
                                        :class="item.markedDelete ? 'bg-slate-200 text-slate-700 hover:bg-slate-300' : 'bg-red-100 text-red-600 hover:bg-red-500 hover:text-white'"
                                        x-text="item.markedDelete ? 'Batal' : 'Hapus'"
                                    ></button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            <div>
                <label for="brochure_files" class="block text-xs font-semibold text-slate-600">
                    Tambah Halaman Brosur Baru (Bisa Pilih Lebih dari 1 Gambar)
                </label>
                <input
                    x-ref="fileInput"
                    type="file"
                    id="brochure_files"
                    name="brochure_files[]"
                    multiple
                    accept="image/jpeg,image/png,image/webp,image/*"
                    x-on:change="handleFiles($event)"
                    class="mt-1.5 w-full rounded-xl border border-dashed border-pondok-primary/40 bg-pondok-accent/50 px-4 py-3 text-sm text-slate-600 file:mr-4 file:rounded-full file:border-0 file:bg-pondok-primary file:px-4 file:py-1.5 file:text-xs file:font-semibold file:text-white hover:file:bg-pondok-secondary"
                >
                <p class="mt-1 text-[11px] text-slate-400">
                    Format JPG/PNG/WebP. Dikompres otomatis kualitas tinggi (maks. 2000px) agar tulisan kecil di tabel biaya tetap tajam terbaca.
                </p>
            </div>

            <div x-show="isCompressing" x-cloak class="flex items-center gap-2 rounded-xl bg-amber-50 px-4 py-2.5 text-xs font-medium text-amber-800">
                <span x-text="statusText"></span>
            </div>
            <div x-show="!isCompressing && statusText" x-cloak class="rounded-xl bg-emerald-50 px-4 py-2 text-xs font-medium text-emerald-700" x-text="statusText"></div>

            <template x-if="queuedFiles.length > 0">
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-slate-600">Siap Diunggah (<span x-text="queuedFiles.length"></span> halaman)</p>
                        <button type="button" x-on:click="clearQueued()" class="text-xs font-semibold text-red-600 hover:underline">Kosongkan pilihan</button>
                    </div>
                    <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 lg:grid-cols-4">
                        <template x-for="(item, index) in queuedFiles" :key="item.uid">
                            <div class="relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50 p-1.5">
                                <div class="relative aspect-[16/11] overflow-hidden rounded-lg bg-white">
                                    <img :src="item.previewUrl" :alt="item.name" class="h-full w-full object-contain">
                                    <button type="button" x-on:click="removeQueued(index)"
                                        class="absolute right-1.5 top-1.5 inline-flex h-6 w-6 items-center justify-center rounded-full bg-black/70 text-xs font-bold text-white hover:bg-red-600">&times;</button>
                                </div>
                                <p class="mt-1 truncate text-[10px] text-slate-500" x-text="item.sizeLabel"></p>
                            </div>
                        </template>
                    </div>
                </div>
            </template>
        </section>

        {{-- 3. Informasi & Jadwal Pendaftaran (/info) --}}
        <section
            x-data="registrationSettingsAdmin({
                periods: @js($initialPeriods),
                requirements: @js($initialRequirements),
                procedures: @js($initialProcedures),
                contacts: @js($initialContacts),
            })"
            class="space-y-6 rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm"
        >
            <input type="hidden" name="registration_section_present" value="1">

            <div>
                <h2 class="text-sm font-semibold text-pondok-primary">3. Informasi &amp; Jadwal Pendaftaran (Halaman Info)</h2>
                <p class="text-xs text-slate-500">Atur biaya pendaftaran, gelombang, persyaratan, teknis, dan kontak panitia yang tampil di halaman /info.</p>
            </div>

            <div class="grid gap-5 md:grid-cols-3">
                <div>
                    <label for="registration_fee" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Biaya Pendaftaran
                    </label>
                    <input type="text" id="registration_fee" name="registration_fee"
                        value="{{ old('registration_fee', $settings->effective_registration_fee) }}"
                        placeholder="Rp 250.000,00"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                </div>
                <div>
                    <label for="registration_button_label" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Teks Tombol Pendaftaran
                    </label>
                    <input type="text" id="registration_button_label" name="registration_button_label"
                        value="{{ old('registration_button_label', $settings->effective_registration_button_label) }}"
                        placeholder="Form Pendaftaran Online"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                </div>
                <div>
                    <label for="registration_url" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        URL Form Pendaftaran (Opsional)
                    </label>
                    <input type="text" id="registration_url" name="registration_url"
                        value="{{ $effectiveRegUrlValue }}"
                        placeholder="/pendaftaran (default web)"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                </div>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="registration_fee_note" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Keterangan Biaya &amp; Potongan
                    </label>
                    <textarea id="registration_fee_note" name="registration_fee_note" rows="3"
                        class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('registration_fee_note', $settings->effective_registration_fee_note) }}</textarea>
                </div>
                <div class="space-y-3">
                    <div>
                        <label for="registration_cta_title" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Judul Ajakan di Kartu Biaya
                        </label>
                        <input type="text" id="registration_cta_title" name="registration_cta_title"
                            value="{{ old('registration_cta_title', $settings->effective_registration_cta_title) }}"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                    </div>
                    <div>
                        <label for="registration_cta_description" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Keterangan Ajakan di Kartu Biaya
                        </label>
                        <input type="text" id="registration_cta_description" name="registration_cta_description"
                            value="{{ old('registration_cta_description', $settings->effective_registration_cta_description) }}"
                            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                    </div>
                </div>
            </div>

            <div class="grid gap-6 border-t border-slate-100 pt-5 lg:grid-cols-2">
                {{-- Periode Pendaftaran --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Periode Pendaftaran</h3>
                        <button type="button" x-on:click="addPeriod()"
                            class="rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary hover:bg-pondok-primary hover:text-white">
                            + Tambah Gelombang
                        </button>
                    </div>
                    <div class="space-y-2.5">
                        <template x-for="(period, index) in periods" :key="index">
                            <div class="flex flex-col gap-2 rounded-xl border border-slate-200 bg-slate-50/70 p-3 sm:flex-row sm:items-center">
                                <input type="text" :name="`registration_periods[${index}][name]`" x-model="period.name"
                                    placeholder="Gelombang 1"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs sm:w-36">
                                <input type="text" :name="`registration_periods[${index}][date]`" x-model="period.date"
                                    placeholder="1 Oktober 2026 – 20 Februari 2027"
                                    class="w-full flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs">
                                <button type="button" x-on:click="periods.splice(index, 1)"
                                    class="self-end rounded-lg bg-red-100 px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-500 hover:text-white sm:self-auto">
                                    Hapus
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Syarat Pendaftaran --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Syarat Pendaftaran</h3>
                        <button type="button" x-on:click="requirements.push('')"
                            class="rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary hover:bg-pondok-primary hover:text-white">
                            + Tambah Syarat
                        </button>
                    </div>
                    <div class="space-y-2.5">
                        <template x-for="(req, index) in requirements" :key="index">
                            <div class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-50/70 p-2.5">
                                <input type="text" name="registration_requirements[]" x-model="requirements[index]"
                                    placeholder="Contoh: Fotokopi Kartu Keluarga"
                                    class="w-full flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs">
                                <button type="button" x-on:click="requirements.splice(index, 1)"
                                    class="rounded-lg bg-red-100 px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-500 hover:text-white">
                                    Hapus
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Teknis Pendaftaran --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Teknis Pendaftaran</h3>
                        <button type="button" x-on:click="procedures.push({ title: '', description: '' })"
                            class="rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary hover:bg-pondok-primary hover:text-white">
                            + Tambah Teknis
                        </button>
                    </div>
                    <div class="space-y-2.5">
                        <template x-for="(proc, index) in procedures" :key="index">
                            <div class="space-y-2 rounded-xl border border-slate-200 bg-slate-50/70 p-3">
                                <div class="flex items-center gap-2">
                                    <input type="text" :name="`registration_procedures[${index}][title]`" x-model="proc.title"
                                        placeholder="Offline / Online"
                                        class="w-full flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold">
                                    <button type="button" x-on:click="procedures.splice(index, 1)"
                                        class="rounded-lg bg-red-100 px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-500 hover:text-white">
                                        Hapus
                                    </button>
                                </div>
                                <textarea :name="`registration_procedures[${index}][description]`" x-model="proc.description" rows="2"
                                    placeholder="Keterangan teknis pendaftaran"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs"></textarea>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Informasi Kontak Panitia --}}
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Kontak Panitia Pendaftaran</h3>
                        <button type="button" x-on:click="contacts.push({ name: '', phone: '' })"
                            class="rounded-full bg-pondok-primary/10 px-3 py-1 text-xs font-semibold text-pondok-primary hover:bg-pondok-primary hover:text-white">
                            + Tambah Kontak
                        </button>
                    </div>
                    <div class="space-y-2.5">
                        <template x-for="(contact, index) in contacts" :key="index">
                            <div class="flex flex-col gap-2 rounded-xl border border-slate-200 bg-slate-50/70 p-3 sm:flex-row sm:items-center">
                                <input type="text" :name="`registration_contacts[${index}][name]`" x-model="contact.name"
                                    placeholder="Nama Panitia (mis. Ust. Ahmad)"
                                    class="w-full flex-1 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs">
                                <input type="text" :name="`registration_contacts[${index}][phone]`" x-model="contact.phone"
                                    placeholder="0812-xxxx-xxxx"
                                    class="w-full rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs sm:w-44">
                                <button type="button" x-on:click="contacts.splice(index, 1)"
                                    class="self-end rounded-lg bg-red-100 px-2.5 py-1.5 text-xs font-semibold text-red-600 hover:bg-red-500 hover:text-white sm:self-auto">
                                    Hapus
                                </button>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. Bagian Hero & Kontak Umum --}}
        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-pondok-primary">4. Bagian Hero Halaman Info</h2>
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
            </div>
        </section>

        <section class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-semibold text-pondok-primary">5. Kontak &amp; Lokasi Umum Pesantren</h2>
            <p class="text-xs text-slate-500">Informasi kontak utama yang ditampilkan pada bagian bawah halaman info.</p>

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

@push('scripts')
    <script>
        (() => {
            const compressBrochureFile = (file, maxDimension = 2000, quality = 0.88) =>
                typeof window.ponpesCompressImageFile === 'function'
                    ? window.ponpesCompressImageFile(file, { maxDimension, quality, minSkipSize: 450 * 1024 })
                    : Promise.resolve(file);

            const formatBytes = (bytes) =>
                typeof window.ponpesFormatBytes === 'function' ? window.ponpesFormatBytes(bytes) : `${Math.round(bytes / 1024)} KB`;

            const registerInfoAdmin = () => {
                Alpine.data('promoBrochuresAdmin', (initialExisting = []) => ({
                    existingBrochures: initialExisting,
                    queuedFiles: [],
                    isCompressing: false,
                    statusText: '',
                    compressionTask: null,

                    init() {
                        const form = this.$el.closest('form');
                        if (form) {
                            form.addEventListener('submit', async (event) => {
                                if (this.isCompressing && this.compressionTask) {
                                    event.preventDefault();
                                    await this.compressionTask;
                                    form.requestSubmit();
                                }
                            });
                        }

                        const bannerInput = document.getElementById('promo_banner');
                        if (bannerInput) {
                            bannerInput.addEventListener('change', async () => {
                                const file = bannerInput.files && bannerInput.files[0];
                                if (!file || typeof DataTransfer === 'undefined') return;
                                const compressed = await compressBrochureFile(file, 1600, 0.85);
                                try {
                                    const dt = new DataTransfer();
                                    dt.items.add(compressed);
                                    bannerInput.files = dt.files;
                                } catch (e) {
                                    // fallback: server GD compresses
                                }
                            });
                        }
                    },

                    get totalActiveCount() {
                        return this.existingBrochures.filter((i) => !i.markedDelete).length + this.queuedFiles.length;
                    },

                    moveExisting(index, delta) {
                        const target = index + delta;
                        if (target < 0 || target >= this.existingBrochures.length) return;
                        const copy = [...this.existingBrochures];
                        const [moved] = copy.splice(index, 1);
                        copy.splice(target, 0, moved);
                        this.existingBrochures = copy;
                    },

                    async handleFiles(event) {
                        const selected = Array.from(event.target.files || []);
                        if (!selected.length) return;

                        this.isCompressing = true;
                        this.statusText = `Mengompres ${selected.length} halaman brosur...`;

                        const run = async () => {
                            let originalBytes = 0;
                            let finalBytes = 0;
                            const nextItems = [];

                            for (let i = 0; i < selected.length; i++) {
                                const rawFile = selected[i];
                                originalBytes += rawFile.size;
                                this.statusText = `Mengompres halaman ${i + 1} dari ${selected.length}...`;

                                const compressed = await compressBrochureFile(rawFile, 2000, 0.88);
                                finalBytes += compressed.size;

                                nextItems.push({
                                    uid: `${Date.now()}-${Math.random().toString(36).slice(2)}-${i}`,
                                    file: compressed,
                                    name: compressed.name,
                                    sizeLabel: formatBytes(compressed.size),
                                    previewUrl: URL.createObjectURL(compressed),
                                });
                            }

                            this.queuedFiles = [...this.queuedFiles, ...nextItems].slice(0, 10);
                            this.syncInputFiles();
                            this.isCompressing = false;
                            this.statusText = `${nextItems.length} halaman siap (${formatBytes(originalBytes)} -> ${formatBytes(finalBytes)}).`;
                        };

                        this.compressionTask = run().finally(() => {
                            this.compressionTask = null;
                        });
                        await this.compressionTask;
                    },

                    removeQueued(index) {
                        const item = this.queuedFiles[index];
                        if (item?.previewUrl) URL.revokeObjectURL(item.previewUrl);
                        this.queuedFiles.splice(index, 1);
                        this.syncInputFiles();
                        if (!this.queuedFiles.length) this.statusText = '';
                    },

                    clearQueued() {
                        this.queuedFiles.forEach((item) => {
                            if (item.previewUrl) URL.revokeObjectURL(item.previewUrl);
                        });
                        this.queuedFiles = [];
                        this.syncInputFiles();
                        this.statusText = '';
                    },

                    syncInputFiles() {
                        const input = this.$refs.fileInput;
                        if (!input || typeof DataTransfer === 'undefined') return;
                        try {
                            const dt = new DataTransfer();
                            this.queuedFiles.forEach((item) => dt.items.add(item.file));
                            input.files = dt.files;
                        } catch (error) {
                            // fallback
                        }
                    },
                }));

                Alpine.data('registrationSettingsAdmin', (initial = {}) => ({
                    periods: Array.isArray(initial.periods) ? initial.periods : [],
                    requirements: Array.isArray(initial.requirements) ? initial.requirements : [],
                    procedures: Array.isArray(initial.procedures) ? initial.procedures : [],
                    contacts: Array.isArray(initial.contacts) ? initial.contacts : [],

                    addPeriod() {
                        this.periods.push({
                            name: `Gelombang ${this.periods.length + 1}`,
                            date: '',
                        });
                    },
                }));
            };

            if (window.Alpine) {
                registerInfoAdmin();
            } else {
                document.addEventListener('alpine:init', registerInfoAdmin);
            }
        })();
    </script>
@endpush
