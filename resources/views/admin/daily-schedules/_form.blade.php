@php
    /** @var \App\Models\DailySchedule|null $schedule */
    $schedule = $schedule ?? null;
@endphp

<div class="space-y-5">
    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="time" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Waktu
            </label>
            <input type="text" id="time" name="time" value="{{ old('time', $schedule?->time) }}" required
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
                placeholder="Contoh: 04.30">
        </div>
        <div>
            <label for="sort_order" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Urutan
            </label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $schedule?->sort_order) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>
    </div>

    <div>
        <label for="activity" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Kegiatan
        </label>
        <input type="text" id="activity" name="activity" value="{{ old('activity', $schedule?->activity) }}" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary"
            placeholder="Contoh: Halaqah Tahfidz & Setoran Hafalan">
    </div>
</div>
