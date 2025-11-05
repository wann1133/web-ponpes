@extends('layouts.admin')

@section('title', 'Ubah Kegiatan | Panel Admin')
@section('page_title', 'Ubah Program/Kegiatan')
@section('breadcrumbs')
    <a href="{{ route('admin.activities.index') }}" class="hover:text-pondok-primary">Program & Kegiatan</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>{{ $activity->title }}</span>
@endsection

@section('content')
    <form action="{{ route('admin.activities.update', $activity) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.activities._form', ['activity' => $activity])

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Perbarui
            </button>
            <a href="{{ route('admin.activities.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
