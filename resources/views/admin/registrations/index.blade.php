@extends('layouts.admin')

@php
    use Illuminate\Support\Str;

    $exportQuery = $jenjang ? ['jenjang' => $jenjang] : [];
@endphp

@section('title', 'Data Pendaftar | Panel Admin')
@section('page_title', 'Data Pendaftar')

@section('breadcrumbs')
    Data Penerimaan / Pendaftar
@endsection

@section('content')
    <div class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-3xl border border-pondok-primary/10 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary/70">Total Pendaftar</p>
            <p class="mt-2 text-3xl font-heading text-pondok-primary">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-3xl border border-pondok-primary/10 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary/70">Jenjang SMP</p>
            <p class="mt-2 text-3xl font-heading text-pondok-primary">{{ $stats['smp'] }}</p>
        </div>
        <div class="rounded-3xl border border-pondok-primary/10 bg-white p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary/70">Jenjang SMA</p>
            <p class="mt-2 text-3xl font-heading text-pondok-primary">{{ $stats['sma'] }}</p>
        </div>
    </div>

    <section class="mt-8 rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
        <header class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div>
                <h2 class="text-sm font-semibold text-pondok-primary">Daftar Calon Santri</h2>
                <p class="text-xs text-slate-500">Gunakan filter untuk menampilkan pendaftar per jenjang.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                <form method="GET" class="flex items-center gap-3">
                    <select
                        name="jenjang"
                        class="rounded-full border border-gray-200 px-4 py-2 text-sm shadow-sm focus:border-pondok-primary focus:outline-none focus:ring-2 focus:ring-pondok-primary/40"
                        onchange="this.form.submit()"
                    >
                        <option value="" @if(!$jenjang) selected @endif>Semua Jenjang</option>
                        <option value="smp" @if($jenjang === 'smp') selected @endif>Jenjang SMP</option>
                        <option value="sma" @if($jenjang === 'sma') selected @endif>Jenjang SMA</option>
                    </select>
                    @if($jenjang)
                        <a
                            href="{{ route('admin.registrations.index') }}"
                            class="text-xs font-semibold text-pondok-primary hover:text-pondok-secondary"
                        >
                            Reset
                        </a>
                    @endif
                </form>
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:gap-2">
                    <a
                        href="{{ route('admin.registrations.export.pdf', $exportQuery) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full border border-pondok-primary px-4 py-2 text-xs font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white"
                    >
                        Export PDF
                    </a>
                    <a
                        href="{{ route('admin.registrations.export.excel', $exportQuery) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full border border-pondok-secondary px-4 py-2 text-xs font-semibold text-pondok-secondary transition hover:bg-pondok-secondary hover:text-white"
                    >
                        Export Excel
                    </a>
                </div>
            </div>
        </header>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-pondok-accent/60">
                    <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                        <th class="px-4 py-3">Nama</th>
                        <th class="px-4 py-3">Jenjang</th>
                        <th class="px-4 py-3">Kontak</th>
                        <th class="px-4 py-3">Orang Tua</th>
                        <th class="px-4 py-3">Asal Sekolah</th>
                        <th class="px-4 py-3">Berkas</th>
                        <th class="px-4 py-3">Tanggal Daftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($registrations as $registration)
                        <tr class="hover:bg-pondok-accent/30">
                            <td class="px-4 py-3 font-medium text-pondok-primary">
                                <div>{{ $registration->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500">
                                    {{ $registration->tempat_lahir }}, {{ $registration->tanggal_lahir?->format('d M Y') }}
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex rounded-full bg-pondok-secondary/10 px-3 py-1 text-xs font-semibold text-pondok-secondary">
                                    {{ strtoupper($registration->jenjang) }}
                                </span>
                                <div class="mt-1 text-xs text-slate-500">{{ $registration->nisn ?? 'NISN -' }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div>{{ $registration->no_wa }}</div>
                                <div class="text-xs text-slate-500">{{ $registration->email ?? 'Email -' }}</div>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-600">
                                <div class="font-semibold text-slate-700">Ayah: {{ $registration->nama_ayah }}</div>
                                <div>Ibu: {{ $registration->nama_ibu }}</div>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-600">
                                {{ $registration->asal_sekolah }}
                                <div class="mt-1 text-[11px] text-slate-500">{{ Str::limit($registration->alamat, 45) }}</div>
                            </td>
                            <td class="px-4 py-3 text-xs">
                                <div class="flex flex-col gap-1">
                                    @if ($registration->berkas_akta_url)
                                        <a href="{{ $registration->berkas_akta_url }}" target="_blank"
                                            class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 text-[11px] font-semibold text-pondok-primary hover:bg-pondok-primary/20">
                                            Akta
                                        </a>
                                    @else
                                        <span class="text-slate-400">Akta -</span>
                                    @endif
                                    @if ($registration->berkas_kk_url)
                                        <a href="{{ $registration->berkas_kk_url }}" target="_blank"
                                            class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 text-[11px] font-semibold text-pondok-primary hover:bg-pondok-primary/20">
                                            KK
                                        </a>
                                    @else
                                        <span class="text-slate-400">KK -</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-4 py-3 text-xs text-slate-500">
                                {{ $registration->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-xs text-slate-500">
                                Belum ada data pendaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $registrations->links() }}
        </div>
    </section>
@endsection
