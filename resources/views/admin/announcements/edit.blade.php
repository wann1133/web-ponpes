@extends('layouts.admin')

@section('title', 'Ubah Pengumuman | Panel Admin')
@section('page_title', 'Ubah Pengumuman')
@section('breadcrumbs')
    <a href="{{ route('admin.announcements.index') }}" class="hover:text-pondok-primary">Pengumuman</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>{{ $announcement->title }}</span>
@endsection

@section('content')
    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.announcements._form', ['announcement' => $announcement])

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Perbarui
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
