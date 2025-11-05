@extends('layouts.admin')

@section('title', 'Tambah Jadwal | Panel Admin')
@section('page_title', 'Tambah Jadwal Harian')
@section('breadcrumbs')
    <a href="{{ route('admin.daily-schedules.index') }}" class="hover:text-pondok-primary">Jadwal Harian</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>Tambah</span>
@endsection

@section('content')
    <form action="{{ route('admin.daily-schedules.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('admin.daily-schedules._form')

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Simpan
            </button>
            <a href="{{ route('admin.daily-schedules.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
