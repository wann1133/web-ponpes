@extends('layouts.admin')

@section('title', 'Ubah Jadwal | Panel Admin')
@section('page_title', 'Ubah Jadwal Harian')
@section('breadcrumbs')
    <a href="{{ route('admin.daily-schedules.index') }}" class="hover:text-pondok-primary">Jadwal Harian</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>{{ $schedule->time }}</span>
@endsection

@section('content')
    <form action="{{ route('admin.daily-schedules.update', $schedule) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.daily-schedules._form', ['schedule' => $schedule])

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Perbarui
            </button>
            <a href="{{ route('admin.daily-schedules.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
