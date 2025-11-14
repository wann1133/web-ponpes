@extends('layouts.admin')

@section('title', 'Pengumuman | Panel Admin')
@section('page_title', 'Pengumuman Pesantren')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-pondok-primary">Pengumuman</h2>
            <p class="text-xs text-slate-500">Kelola pengumuman yang akan tampil pada halaman info pesantren.</p>
        </div>
        <a href="{{ route('admin.announcements.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            Tambah Pengumuman
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-pondok-accent/50 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3 w-32">Tanggal</th>
                    <th class="px-6 py-3 w-32">Kategori</th>
                    <th class="px-6 py-3 w-24 text-center">Status</th>
                    <th class="px-6 py-3 w-36 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($announcements as $announcement)
                    <tr class="hover:bg-pondok-accent/40">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-pondok-primary">{{ $announcement->title }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($announcement->summary, 100) }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $announcement->formattedDate() ?? '-' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $announcement->type ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $announcement->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                {{ $announcement->is_active ? 'Aktif' : 'Arsip' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 text-xs">
                                <a href="{{ route('admin.announcements.edit', $announcement) }}"
                                    class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white">
                                    Edit
                                </a>
                                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" data-confirm-delete="Hapus pengumuman ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 font-semibold text-red-600 transition hover:bg-red-500 hover:text-white">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-xs text-slate-500">
                            Belum ada pengumuman.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
