@extends('layouts.admin')

@section('title', 'Tambah FAQ | Panel Admin')
@section('page_title', 'Tambah FAQ')
@section('breadcrumbs')
    <a href="{{ route('admin.faqs.index') }}" class="hover:text-pondok-primary">FAQ</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>Tambah</span>
@endsection

@section('content')
    <form action="{{ route('admin.faqs.store') }}" method="POST" class="space-y-6">
        @csrf
        @include('admin.faqs._form')

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Simpan
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
