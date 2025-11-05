@extends('layouts.admin')

@section('title', 'Tambah Pengumuman | Panel Admin')
@section('page_title', 'Tambah Pengumuman')
@section('breadcrumbs')
    <a href="{{ route('admin.announcements.index') }}" class="hover:text-pondok-primary">Pengumuman</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>Tambah</span>
@endsection

@section('content')
    <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('admin.announcements._form')

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Simpan
            </button>
            <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
