@props(['navigation' => []])

@php
    $logoPath = null;
    foreach (['logo baru.png', 'logo.svg', 'logoo.jpg', 'logoo.png'] as $logoCandidate) {
        if (file_exists(public_path($logoCandidate))) {
            $logoPath = asset($logoCandidate);
            break;
        }
    }
@endphp

<header
    x-data="{ open: false }"
    class="fixed inset-x-0 top-0 z-50 border-b border-white/60 bg-white/95 backdrop-blur-md shadow-sm transition-shadow duration-200"
>
    <div class="mx-auto flex max-w-7xl items-center gap-4 px-6 py-4 lg:gap-8 lg:px-10">
        <a href="{{ url('/') }}" class="flex items-center">
            @if ($logoPath)
                <img src="{{ $logoPath }}" alt="Logo Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas"
                    class="h-10 w-auto max-w-none object-contain sm:h-12 lg:h-14">
            @else
                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-pondok-primary text-white font-heading text-lg sm:h-12 sm:w-12">
                    NI
                </span>
            @endif
            <span class="sr-only">Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas</span>
        </a>

        <nav class="hidden flex-1 items-center justify-center gap-10 text-sm font-medium lg:flex">
            @foreach ($navigation as $item)
                @php
                    $isActive = $item['active'] ?? false;
                @endphp
                <a
                    href="{{ $item['href'] }}"
                    class="relative inline-flex items-center px-1.5 py-2 transition duration-200 {{ $isActive ? 'font-semibold text-pondok-primary' : 'text-gray-600 hover:text-pondok-primary' }}"
                >
                    {{ $item['label'] }}
                    @if($isActive)
                        <span class="pointer-events-none absolute left-0 right-0 -bottom-1 h-0.5 rounded-full bg-pondok-secondary transition-all duration-200"></span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-4 lg:flex">
            <a
                href="{{ url('/info#contact') }}"
                class="text-sm font-medium text-gray-600 transition duration-200 hover:text-pondok-primary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pondok-primary"
            >
                Hubungi Kami
            </a>
            <a
                href="{{ route('pendaftaran.index') }}"
                class="inline-flex items-center rounded-full bg-pondok-primary px-5 py-2 text-sm font-semibold text-white shadow-md transition duration-200 hover:bg-pondok-secondary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pondok-primary"
            >
                Pendaftaran
            </a>
        </div>

        <button
            type="button"
            class="ml-auto inline-flex items-center justify-center rounded-xl border border-pondok-primary/20 p-2 text-pondok-primary shadow-sm transition duration-200 hover:bg-pondok-primary/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pondok-primary lg:hidden"
            x-on:click="open = !open"
            :aria-expanded="open"
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
        x-transition.opacity.scale
        x-cloak
        class="border-t border-pondok-primary/10 bg-white shadow-lg transition duration-200 lg:hidden"
    >
        <nav class="space-y-2 px-6 py-5 text-sm text-gray-700">
            @foreach ($navigation as $item)
                @php
                    $isActive = $item['active'] ?? false;
                @endphp
                <a
                    href="{{ $item['href'] }}"
                    class="flex items-center justify-between rounded-xl px-4 py-3 transition duration-200 {{ $isActive ? 'bg-pondok-accent/40 font-semibold text-pondok-primary' : 'hover:bg-pondok-accent/40' }}"
                    x-on:click="open = false"
                >
                    <span>{{ $item['label'] }}</span>
                    @if($isActive)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-pondok-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    @endif
                </a>
            @endforeach
            <a
                href="{{ url('/info#contact') }}"
                class="inline-flex w-full items-center justify-center rounded-full bg-pondok-primary px-4 py-3 text-sm font-semibold text-white shadow-md transition duration-200 hover:bg-pondok-secondary focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pondok-primary"
            >
                Hubungi Kami
            </a>
            <a
                href="{{ route('pendaftaran.index') }}"
                class="inline-flex w-full items-center justify-center rounded-full border border-pondok-primary px-4 py-3 text-sm font-semibold text-pondok-primary transition duration-200 hover:bg-pondok-primary/10 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-pondok-primary"
                x-on:click="open = false"
            >
                Pendaftaran
            </a>
        </nav>
    </div>
</header>
