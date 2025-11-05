@php
    /** @var \App\Models\Activity|null $activity */
    $activity = $activity ?? null;
@endphp

<div class="space-y-5">
    <div>
        <label for="title" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Judul Kegiatan
        </label>
        <input type="text" id="title" name="title" value="{{ old('title', $activity?->title) }}" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
    </div>

    <div>
        <label for="description" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Deskripsi
        </label>
        <textarea id="description" name="description" rows="4" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('description', $activity?->description) }}</textarea>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="schedule" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Jadwal
            </label>
            <input type="text" id="schedule" name="schedule" value="{{ old('schedule', $activity?->schedule) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                placeholder="Contoh: Senin - Kamis | 08.00 - 11.30 WIB">
        </div>

        <div>
            <label for="sort_order" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Urutan Tampil
            </label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $activity?->sort_order) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
            <p class="mt-1 text-[11px] text-slate-400">Angka lebih kecil muncul lebih awal.</p>
        </div>
    </div>
</div>
