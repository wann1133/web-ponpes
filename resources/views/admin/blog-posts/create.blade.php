@extends('layouts.admin')

@section('title', 'Tulis Artikel | Panel Admin')
@section('page_title', 'Tulis Artikel Baru')
@section('breadcrumbs')
    <a href="{{ route('admin.blog-posts.index') }}" class="hover:text-pondok-primary">Blog</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>Tulis</span>
@endsection

@section('content')
    <form action="{{ route('admin.blog-posts.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.blog-posts._form')

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Simpan Artikel
            </button>
            <a href="{{ route('admin.blog-posts.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
