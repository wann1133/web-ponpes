@php
    /** @var \App\Models\Announcement|null $announcement */
    $announcement = $announcement ?? null;
@endphp

<div class="space-y-5">
    <div>
        <label for="title" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Judul Pengumuman
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $announcement?->title) }}" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
    </div>

    <div>
        <label for="summary" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Ringkasan
        </label>
        <textarea id="summary" name="summary" rows="4" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('summary', $announcement?->summary) }}</textarea>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
        <div>
            <label for="announcement_date" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Tanggal
            </label>
            <input type="date" id="announcement_date" name="announcement_date"
                value="{{ old('announcement_date', optional($announcement?->announcement_date)->format('Y-m-d')) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>

        <div>
            <label for="type" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Kategori
            </label>
            <input type="text" id="type" name="type" value="{{ old('type', $announcement?->type) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                placeholder="Contoh: Pendaftaran, Akademik">
        </div>

        <div>
            <label for="sort_order" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Urutan
            </label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $announcement?->sort_order) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>
    </div>

    <div class="flex items-center gap-2">
        <input type="checkbox" id="is_active" name="is_active" value="1"
            class="h-4 w-4 rounded border-slate-300 text-pondok-primary focus:ring-pondok-primary"
            @checked(old('is_active', $announcement?->is_active ?? true))>
        <label for="is_active" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Tampilkan di halaman info
        </label>
    </div>
</div>
