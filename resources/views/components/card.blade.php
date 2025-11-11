@props([
    'title',
    'description' => null,
    'icon' => null,
    'href' => null,
    'tag' => null,
    'meta' => null,
])

@php
    $linkClasses = 'h-full transition hover:-translate-y-1 hover:shadow-soft focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-pondok-secondary/70 focus-visible:ring-offset-2';
    $wrapperClasses = 'flex h-full flex-col rounded-3xl border border-pondok-primary/10 bg-white/90 p-8 shadow-sm transition duration-200';
@endphp

<div @class([$linkClasses])>
    @if ($href)
        <a href="{{ $href }}" class="block h-full">
            <div @class([$wrapperClasses])>
                @if ($tag)
                    <span class="inline-flex items-center rounded-full bg-pondok-accent px-3 py-1 text-xs font-semibold text-pondok-primary">
                        {{ $tag }}
                    </span>
                @endif

                <div class="mt-4 flex items-start gap-4">
                    @if ($icon)
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pondok-primary/10 text-pondok-primary">
                            {!! $icon !!}
                        </div>
                    @endif
                    <div class="space-y-3">
                        <h3 class="text-xl font-semibold text-pondok-primary">{{ $title }}</h3>
                        @if ($description)
                            <p class="text-sm text-gray-600">{{ $description }}</p>
                        @endif
                        @if ($meta)
                            <div class="text-xs font-medium text-pondok-primary/70">{{ $meta }}</div>
                        @endif
                        <span class="inline-flex items-center gap-2 text-sm font-semibold text-pondok-primary">
                            Selengkapnya
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l5 5a1 1 0 010 1.414l-5 5a1 1 0 01-1.414-1.414L13.586 10 10.293 6.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                                <path fill-rule="evenodd"
                                    d="M3 10a1 1 0 011-1h11a1 1 0 110 2H4a1 1 0 01-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </a>
    @else
        <div @class([$wrapperClasses])>
            @if ($tag)
                <span class="inline-flex items-center rounded-full bg-pondok-accent px-3 py-1 text-xs font-semibold text-pondok-primary">
                    {{ $tag }}
                </span>
            @endif

            <div class="mt-4 flex items-start gap-4">
                @if ($icon)
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-pondok-primary/10 text-pondok-primary">
                        {!! $icon !!}
                    </div>
                @endif
                <div class="space-y-3">
                    <h3 class="text-xl font-semibold text-pondok-primary">{{ $title }}</h3>
                    @if ($description)
                        <p class="text-sm text-gray-600">{{ $description }}</p>
                    @endif
                    @if ($meta)
                        <div class="text-xs font-medium text-pondok-primary/70">{{ $meta }}</div>
                    @endif
                    {{ $slot }}
                </div>
            </div>
        </div>
    @endif
</div>
