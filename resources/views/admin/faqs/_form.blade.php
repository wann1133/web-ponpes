@php
    /** @var \App\Models\Faq|null $faq */
    $faq = $faq ?? null;
@endphp

<div class="space-y-5">
    <div>
        <label for="question" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Pertanyaan
        </label>
        <input type="text" id="question" name="question" value="{{ old('question', $faq?->question) }}" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
    </div>

    <div>
        <label for="answer" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
            Jawaban
        </label>
        <textarea id="answer" name="answer" rows="4" required
            class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">{{ old('answer', $faq?->answer) }}</textarea>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
        <div>
            <label for="sort_order" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Urutan
            </label>
            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $faq?->sort_order) }}"
                class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
        </div>

        <div class="flex items-center gap-2 pt-6">
            <input type="checkbox" id="is_active" name="is_active" value="1"
                class="h-4 w-4 rounded border-slate-300 text-pondok-primary focus:ring-pondok-primary"
                @checked(old('is_active', $faq?->is_active ?? true))>
            <label for="is_active" class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                Tampilkan
            </label>
        </div>
    </div>
</div>
