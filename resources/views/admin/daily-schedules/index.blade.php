@extends('layouts.admin')

@section('title', 'Jadwal Harian | Panel Admin')
@section('page_title', 'Jadwal Harian Santri')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-pondok-primary">Jadwal Harian</h2>
            <p class="text-xs text-slate-500">Atur urutan kegiatan harian santri yang tampil di halaman info.</p>
        </div>
        <a href="{{ route('admin.daily-schedules.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            Tambah Jadwal
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-pondok-accent/50 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-6 py-3 w-32">Waktu</th>
                    <th class="px-6 py-3">Kegiatan</th>
                    <th class="px-6 py-3 w-24 text-center">Urutan</th>
                    <th class="px-6 py-3 w-32 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($schedules as $schedule)
                    <tr class="hover:bg-pondok-accent/40">
                        <td class="px-6 py-4 font-semibold text-pondok-primary">{{ $schedule->time }}</td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $schedule->activity }}</td>
                        <td class="px-6 py-4 text-center text-xs text-slate-500">{{ $schedule->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 text-xs">
                                <a href="{{ route('admin.daily-schedules.edit', $schedule) }}"
                                    class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white">
                                    Edit
                                </a>
                                <form action="{{ route('admin.daily-schedules.destroy', $schedule) }}" method="POST"
                                    onsubmit="return confirm('Hapus jadwal ini?');">
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
                            Belum ada jadwal harian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
