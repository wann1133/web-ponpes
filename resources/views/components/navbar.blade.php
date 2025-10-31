@props(['navigation' => []])

<header
    x-data="{ open: false }"
    class="fixed inset-x-0 top-0 z-50 bg-white/80 backdrop-blur-md shadow-sm"
>
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4 lg:px-10">
        <a href="{{ url('/') }}" class="flex items-center gap-3">
            <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pondok-primary text-white font-heading text-xl">
                NI
            </span>
            <div class="flex flex-col">
                <span class="font-heading text-lg text-pondok-primary">Nurul Ikhlas</span>
                <span class="text-sm text-gray-500">Tahfidzul Qur'an</span>
            </div>
        </a>

        <nav class="hidden items-center gap-8 text-sm font-medium text-gray-600 lg:flex">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['href'] }}"
                    class="relative transition hover:text-pondok-primary"
                >
                    {{ $item['label'] }}
                    @if($item['active'] ?? false)
                        <span class="absolute left-0 right-0 -bottom-2 h-1 rounded-full bg-pondok-secondary"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="hidden lg:block">
            <a href="{{ url('/info#contact') }}" class="btn-primary text-sm">
                Hubungi Kami
            </a>
        </div>

        <button
            type="button"
            class="inline-flex items-center justify-center rounded-xl border border-pondok-primary/20 p-2 text-pondok-primary transition hover:bg-pondok-primary/10 lg:hidden"
            x-on:click="open = !open"
            aria-label="Toggle mobile navigation"
        >
            <svg
                x-show="!open"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="h-6 w-6"
            >
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg
                x-show="open"
                x-cloak
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                class="h-6 w-6"
            >
                <path d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div
        x-show="open"
        x-transition
        x-cloak
        class="border-t border-pondok-primary/10 bg-white lg:hidden"
    >
        <nav class="space-y-1 px-6 py-4 text-sm text-gray-700">
            @foreach ($navigation as $item)
                <a
                    href="{{ $item['href'] }}"
                    class="flex items-center justify-between rounded-xl px-4 py-3 transition hover:bg-pondok-accent"
                    x-on:click="open = false"
                >
                    <span>{{ $item['label'] }}</span>
                    @if($item['active'] ?? false)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pondok-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
            <a href="{{ url('/info#contact') }}" class="btn-primary w-full text-center">
                Hubungi Kami
            </a>
        </nav>
    </div>
</header>
