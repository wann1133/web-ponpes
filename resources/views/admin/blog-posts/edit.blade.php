@extends('layouts.admin')

@section('title', 'Ubah Artikel | Panel Admin')
@section('page_title', 'Ubah Artikel Blog')
@section('breadcrumbs')
    <a href="{{ route('admin.blog-posts.index') }}" class="hover:text-pondok-primary">Blog</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>{{ $post->title }}</span>
@endsection

@section('content')
    <form action="{{ route('admin.blog-posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.blog-posts._form', ['post' => $post])

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Perbarui Artikel
            </button>
            <a href="{{ route('admin.blog-posts.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
