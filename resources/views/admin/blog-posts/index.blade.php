@extends('layouts.admin')

@section('title', 'Blog | Panel Admin')
@section('page_title', 'Artikel Blog Pesantren')

@section('content')
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-pondok-primary">Artikel Blog</h2>
            <p class="text-xs text-slate-500">Kelola artikel yang tampil pada halaman blog dan beranda.</p>
        </div>
        <a href="{{ route('admin.blog-posts.create') }}" class="btn-primary inline-flex items-center gap-2 text-sm">
            Tulis Artikel
        </a>
    </div>

    <div class="mt-6 overflow-hidden rounded-3xl border border-pondok-primary/10 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-pondok-accent/50 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                <tr>
                    <th class="px-6 py-3">Judul</th>
                    <th class="px-6 py-3 w-32">Kategori</th>
                    <th class="px-6 py-3 w-32">Penulis</th>
                    <th class="px-6 py-3 w-32 text-center">Status</th>
                    <th class="px-6 py-3 w-36 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 bg-white">
                @forelse ($posts as $post)
                    <tr class="hover:bg-pondok-accent/40">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-pondok-primary">{{ $post->title }}</p>
                            <p class="mt-1 text-xs text-slate-500">{{ $post->formatted_date }}</p>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $post->category ?? '-' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500">{{ $post->author ?? '-' }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1 text-[11px] font-semibold">
                                <span class="inline-flex rounded-full px-2.5 py-1 {{ $post->is_published ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
                                    {{ $post->is_published ? 'Terbit' : 'Draft' }}
                                </span>
                                @if ($post->is_featured)
                                    <span class="inline-flex rounded-full bg-pondok-primary/10 px-2 py-0.5 text-pondok-primary">
                                        Sorotan
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2 text-xs">
                                <a href="{{ route('admin.blog-posts.edit', $post) }}"
                                    class="inline-flex items-center gap-1 rounded-full bg-pondok-primary/10 px-3 py-1 font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white">
                                    Edit
                                </a>
                                <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" data-confirm-delete="Hapus artikel ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center gap-1 rounded-full bg-red-100 px-3 py-1 font-semibold text-red-600 transition hover:bg-red-500 hover:text-white">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-xs text-slate-500">
                            Belum ada artikel blog.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
