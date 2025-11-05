@extends('layouts.admin')

@section('title', 'Program & Kegiatan | Panel Admin')
@section('page_title', 'Program & Kegiatan')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-pondok-primary">Daftar Kegiatan Utama</h2>
            <p class="text-xs text-slate-500">Atur kegiatan yang ditampilkan pada halaman info pesantren.</p>
        </div>
        <a href="{{ route('admin.activities.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            Tambah Kegiatan
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-pondok-accent/50 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3 w-52">Jadwal</th>
                    <th class="px-6 py-3 w-24 text-center">Urutan</th>
                    <th class="px-6 py-3 w-36 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($activities as $activity)
                    <tr class="hover:bg-pondok-accent/40">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-pondok-primary">{{ $activity->title }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ \Illuminate\Support\Str::limit($activity->description, 90) }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">{{ $activity->schedule ?? '-' }}</td>
                        <td class="px-6 py-4 text-center text-xs text-slate-500">{{ $activity->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 text-xs">
                                <a href="{{ route('admin.activities.edit', $activity) }}"
                                    class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white">
                                    Edit
                                </a>
                                <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST"
                                    onsubmit="return confirm('Hapus kegiatan ini?');">
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
                        <td colspan="4" class="px-6 py-4 text-center text-xs text-slate-500">
                            Belum ada data kegiatan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
