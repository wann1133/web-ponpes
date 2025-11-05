@php
    $contacts = [
        [
            'label' => 'Admin Pendaftaran',
            'number' => '6281234567890',
            'display' => '+62 812-3456-7890',
        ],
        [
            'label' => 'Admin Akademik',
            'number' => '6285212345678',
            'display' => '+62 852-1234-5678',
        ],
        [
            'label' => 'Admin Asrama',
            'number' => '6289876543210',
            'display' => '+62 898-7654-3210',
        ],
    ];
@endphp

<div
    x-data="{ open: false }"
    class="fixed bottom-6 right-6 z-50 flex flex-col items-end space-y-3"
>
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-2"
        x-cloak
        class="w-72 rounded-3xl border border-pondok-primary/10 bg-white p-5 shadow-soft"
    >
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Hubungi Kami</p>
                <p class="mt-1 text-sm text-gray-600">Pilih admin WhatsApp yang ingin Anda hubungi.</p>
            </div>
            <button
                type="button"
                class="rounded-full p-1.5 text-gray-400 transition hover:bg-pondok-accent hover:text-pondok-primary"
                x-on:click="open = false"
                aria-label="Tutup daftar kontak WhatsApp"
            >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="1.8" class="h-4 w-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <ul class="mt-4 space-y-3">
            @foreach ($contacts as $contact)
                <li>
                    <a
                        href="https://wa.me/{{ $contact['number'] }}"
                        target="_blank"
                        rel="noopener"
                        class="flex items-center gap-3 rounded-2xl border border-pondok-primary/10 bg-pondok-accent px-3 py-3 text-left transition hover:-translate-y-0.5 hover:border-pondok-primary/30 hover:bg-pondok-primary/5 hover:shadow-soft"
                    >
                        <span class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-2xl bg-pondok-primary text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
                                <path
                                    d="M12.004 2.25A9.71 9.71 0 007.18 4.025C3.672 6.5 2.145 11.053 3.817 15.041L2.25 21.75l6.842-1.566c1.048.44 2.172.666 3.309.666h.004c5.385 0 9.75-4.365 9.75-9.75 0-2.603-1.014-5.05-2.857-6.893A9.682 9.682 0 0012.004 2.25zm5.707 14.207c-.243.685-1.4 1.307-1.931 1.35-.495.038-1.11.055-1.797-.113-.414-.1-.946-.308-1.634-.604-2.874-1.241-4.748-4.137-4.886-4.332-.14-.194-1.171-1.557-1.171-2.971 0-1.413.742-2.109 1.005-2.402.263-.294.575-.368.767-.368h.548c.177.004.398-.066.624.474.243.584.828 2.027.9 2.173.07.146.117.317.02.512-.09.19-.136.308-.268.474-.132.167-.281.372-.402.5-.132.134-.269.281-.116.552.153.271.683 1.126 1.468 1.822 1.01.898 1.861 1.181 2.132 1.314.271.134.423.116.577-.07.153-.186.655-.764.83-1.026.174-.263.348-.219.585-.132.237.087 1.5.708 1.759.836.258.128.43.19.493.296.063.109.063.626-.18 1.311z" />
                            </svg>
                        </span>
                        <span class="flex flex-col">
                            <span class="text-sm font-semibold text-pondok-primary">{{ $contact['label'] }}</span>
                            <span class="text-xs text-gray-500">{{ $contact['display'] }}</span>
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <button
        type="button"
        class="inline-flex items-center gap-2 rounded-full bg-pondok-primary px-5 py-3 text-sm font-semibold text-white shadow-soft transition hover:bg-pondok-secondary focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pondok-secondary/70 focus-visible:ring-offset-2"
        x-on:click="open = !open"
        :aria-expanded="open"
        aria-label="Tampilkan daftar kontak WhatsApp"
    >
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5">
            <path
                d="M12.004 2.25A9.71 9.71 0 007.18 4.025C3.672 6.5 2.145 11.053 3.817 15.041L2.25 21.75l6.842-1.566c1.048.44 2.172.666 3.309.666h.004c5.385 0 9.75-4.365 9.75-9.75 0-2.603-1.014-5.05-2.857-6.893A9.682 9.682 0 0012.004 2.25zm5.707 14.207c-.243.685-1.4 1.307-1.931 1.35-.495.038-1.11.055-1.797-.113-.414-.1-.946-.308-1.634-.604-2.874-1.241-4.748-4.137-4.886-4.332-.14-.194-1.171-1.557-1.171-2.971 0-1.413.742-2.109 1.005-2.402.263-.294.575-.368.767-.368h.548c.177.004.398-.066.624.474.243.584.828 2.027.9 2.173.07.146.117.317.02.512-.09.19-.136.308-.268.474-.132.167-.281.372-.402.5-.132.134-.269.281-.116.552.153.271.683 1.126 1.468 1.822 1.01.898 1.861 1.181 2.132 1.314.271.134.423.116.577-.07.153-.186.655-.764.83-1.026.174-.263.348-.219.585-.132.237.087 1.5.708 1.759.836.258.128.43.19.493.296.063.109.063.626-.18 1.311z" />
        </svg>
        <span>WhatsApp</span>
        <span
            class="inline-flex h-5 w-5 items-center justify-center rounded-full bg-white/20 text-xs font-semibold text-white"
        >
            3
        </span>
    </button>
</div>
