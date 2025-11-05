@extends('layouts.admin')

@section('title', 'Tambah Kegiatan | Panel Admin')
@section('page_title', 'Tambah Program/Kegiatan')
@section('breadcrumbs')
    <a href="{{ route('admin.activities.index') }}" class="hover:text-pondok-primary">Program & Kegiatan</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>Tambah</span>
@endsection

@section('content')
    <form action="{{ route('admin.activities.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('admin.activities._form')

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Simpan
            </button>
            <a href="{{ route('admin.activities.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
