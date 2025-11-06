<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel Admin | Nurul Ikhlas')</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('logo.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

    @php
        $logoPath = null;
        foreach (['logo.svg', 'logoo.jpg', 'logoo.png'] as $logoCandidate) {
            if (file_exists(public_path($logoCandidate))) {
                $logoPath = asset($logoCandidate);
                break;
            }
        }
    @endphp

    <body class="bg-slate-100 font-sans text-gray-800 antialiased">
        <div class="min-h-screen lg:flex">
            <aside id="adminSidebar" class="bg-white shadow-lg lg:w-64">
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if ($logoPath)
                            <img
                                src="{{ $logoPath }}"
                                alt="Logo Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas"
                                class="h-7 w-auto max-w-[140px] object-contain"
                            >
                        @else
                            <span class="flex h-8 w-8 items-center justify-center rounded-full bg-pondok-primary text-white font-heading text-base">
                                NI
                            </span>
                        @endif
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-pondok-primary">Panel Admin</p>
                        </div>
                    </div>
                    <button type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true"
                        class="rounded-full p-2 text-pondok-primary transition hover:bg-pondok-primary/10 focus:outline-none focus:ring-2 focus:ring-pondok-primary/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7.5C3 5.015 5.015 3 7.5 3h9A4.5 4.5 0 0121 7.5v9A4.5 4.5 0 0116.5 21h-9A4.5 4.5 0 013 16.5v-9z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 7.5h4.5m-4.5 3h4.5m-4.5 3h2.25" />
                    </svg>
                </button>
            </div>

            @php
                $adminNavigation = [
                    ['label' => 'Dashboard', 'icon' => 'home', 'route' => 'admin.dashboard'],
                    ['label' => 'Program & Kegiatan', 'icon' => 'calendar', 'route' => 'admin.activities.index'],
                    ['label' => 'Pengumuman', 'icon' => 'megaphone', 'route' => 'admin.announcements.index'],
                    ['label' => 'Jadwal Harian', 'icon' => 'clock', 'route' => 'admin.daily-schedules.index'],
                    ['label' => 'FAQ', 'icon' => 'question-mark-circle', 'route' => 'admin.faqs.index'],
                    ['label' => 'Halaman Info', 'icon' => 'document-text', 'route' => 'admin.info-page.edit'],
                    ['label' => 'Blog', 'icon' => 'newspaper', 'route' => 'admin.blog-posts.index'],
                    ['label' => 'Pendaftar', 'icon' => 'users', 'route' => 'admin.registrations.index'],
                ];
                $icons = [
                    'home' => 'M3 9.75L12 3l9 6.75V20.25a.75.75 0 01-.75.75h-5.25v-5.25h-6v5.25H3.75a.75.75 0 01-.75-.75V9.75z',
                    'calendar' => 'M6.75 4.5v1.5m10.5-1.5v1.5M4.5 9.75h15m-12 3h3m-3 3h3M4.5 7.5a2.25 2.25 0 012.25-2.25h10.5A2.25 2.25 0 0119.5 7.5v10.5A2.25 2.25 0 0117.25 20.25H6.75A2.25 2.25 0 014.5 18V7.5z',
                    'megaphone' => 'M4.5 9v6.75A1.5 1.5 0 005.25 17.25h1.5A1.5 1.5 0 008.25 15.75V12l9 3v-6l-9 3V8.25A1.5 1.5 0 006.75 6.75h-1.5A1.5 1.5 0 003.75 8.25V9h.75z',
                    'clock' => 'M12 6a6 6 0 110 12 6 6 0 010-12zm0 0v3.75l2.25 2.25',
                    'question-mark-circle' => 'M12 17.25h.007M12 6.75a3 3 0 00-3 3h1.5a1.5 1.5 0 113 0c0 1.5-2.25 1.312-2.25 3.75m.75 3.75h.007',
                    'document-text' => 'M9 3.75h6l3 3v12a1.5 1.5 0 01-1.5 1.5H9A1.5 1.5 0 017.5 18.75V5.25A1.5 1.5 0 019 3.75zm0 6h6m-6 3h6m-6 3h3',
                    'newspaper' => 'M4.5 5.25h15v13.5h-15A1.5 1.5 0 013 17.25V6.75A1.5 1.5 0 014.5 5.25zm12 3h-4.5m4.5 3h-4.5m4.5 3H12',
                    'users' => 'M15 19.5v-1.125A3.375 3.375 0 0011.625 15h-5.25A3.375 3.375 0 003 18.375V19.5m17.25 0v-1.125A3.375 3.375 0 0016.875 15H16.5m-3-6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm6.75 3.375a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z',
                ];
            @endphp

            <nav class="space-y-1 px-2 py-4">
                @foreach ($adminNavigation as $item)
                    <a href="{{ route($item['route']) }}"
                        class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition {{ request()->routeIs($item['route']) ? 'bg-pondok-primary text-white shadow-soft' : 'text-slate-600 hover:bg-pondok-primary/10 hover:text-pondok-primary' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$item['icon']] ?? $icons['home'] }}" />
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </aside>

        <div class="flex-1">
            <header class="flex flex-col gap-4 border-b border-slate-200 bg-white/70 px-6 py-4 backdrop-blur sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-pondok-primary">@yield('page_title', 'Panel Admin')</h1>
                    @hasSection('breadcrumbs')
                        <div class="text-xs text-slate-500">@yield('breadcrumbs')</div>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <button type="button" data-sidebar-toggle aria-controls="adminSidebar" aria-expanded="true"
                        class="rounded-full p-2 text-pondok-primary transition hover:bg-pondok-primary/10 focus:outline-none focus:ring-2 focus:ring-pondok-primary/30">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 7.5C3 5.015 5.015 3 7.5 3h9A4.5 4.5 0 0121 7.5v9A4.5 4.5 0 0116.5 21h-9A4.5 4.5 0 013 16.5v-9z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.75 7.5h4.5m-4.5 3h4.5m-4.5 3h2.25" />
                        </svg>
                        <span class="sr-only">Toggle sidebar</span>
                    </button>
                    <span class="text-sm text-slate-500">{{ auth()->user()->name ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center gap-1 rounded-full border border-pondok-primary px-4 py-1.5 text-xs font-semibold text-pondok-primary transition hover:bg-pondok-primary hover:text-white">
                            Keluar
                        </button>
                    </form>
                </div>
            </header>

            <main class="px-6 py-6">
                @include('admin.partials.flash')
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('adminSidebar');
            const toggleButtons = document.querySelectorAll('[data-sidebar-toggle]');

            if (!sidebar || toggleButtons.length === 0) {
                return;
            }

            let isHidden = false;

            const setSidebarState = (isOpen) => {
                isHidden = !isOpen;
                sidebar.classList.toggle('hidden', isHidden);
                toggleButtons.forEach((button) => button.setAttribute('aria-expanded', String(isOpen)));
            };

            toggleButtons.forEach((button) => {
                button.addEventListener('click', () => setSidebarState(isHidden));
            });

            window.addEventListener('resize', () => {
                if (window.innerWidth >= 1024 && isHidden) {
                    setSidebarState(true);
                }
            });
        });
    </script>
</body>

</html>
