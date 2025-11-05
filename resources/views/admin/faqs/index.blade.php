@extends('layouts.admin')

@section('title', 'FAQ | Panel Admin')
@section('page_title', 'Pertanyaan yang Sering Diajukan')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-pondok-primary">FAQ</h2>
            <p class="text-xs text-slate-500">Kelola daftar pertanyaan umum untuk halaman info pesantren.</p>
        </div>
        <a href="{{ route('admin.faqs.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            Tambah FAQ
        </a>
    </div>

    <div class="mt-6 space-y-4">
        @forelse ($faqs as $faq)
            <div class="rounded-3xl border border-pondok-primary/10 bg-white p-6 shadow-sm">
                <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary/70">Urutan:
                            {{ $faq->sort_order }}</p>
                        <h3 class="mt-1 text-base font-semibold text-pondok-primary">{{ $faq->question }}</h3>
                        <p class="mt-2 text-sm text-slate-600">{{ $faq->answer }}</p>
                    </div>
                    <div class="flex items-center gap-2 text-xs">
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 font-semibold {{ $faq->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                            {{ $faq->is_active ? 'Aktif' : 'Sembunyikan' }}
                        </span>
                        <a href="{{ route('admin.faqs.edit', $faq) }}"
                            class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white">
                            Edit
                        </a>
                        <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"
                            onsubmit="return confirm('Hapus FAQ ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 font-semibold text-red-600 transition hover:bg-red-500 hover:text-white">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="rounded-3xl border border-dashed border-pondok-primary/30 bg-white p-6 text-center text-xs text-slate-500">
                Belum ada data FAQ.
            </div>
        @endforelse
    </div>
@endsection
