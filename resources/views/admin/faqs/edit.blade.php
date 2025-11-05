@extends('layouts.admin')

@section('title', 'Ubah FAQ | Panel Admin')
@section('page_title', 'Ubah FAQ')
@section('breadcrumbs')
    <a href="{{ route('admin.faqs.index') }}" class="hover:text-pondok-primary">FAQ</a>
    <span class="mx-1 text-slate-400">/</span>
    <span>{{ $faq->question }}</span>
@endsection

@section('content')
    <form action="{{ route('admin.faqs.update', $faq) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @include('admin.faqs._form', ['faq' => $faq])

        <div class="flex items-center gap-3">
            <button type="submit" class="btn-primary">
                Perbarui
            </button>
            <a href="{{ route('admin.faqs.index') }}" class="btn-secondary">
                Batal
            </a>
        </div>
    </form>
@endsection
