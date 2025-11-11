@php
    $navigation = [
        ['label' => 'Beranda', 'href' => route('home'), 'active' => request()->routeIs('home')],
        ['label' => 'Info Pesantren', 'href' => route('info'), 'active' => request()->routeIs('info')],
        ['label' => 'Blog', 'href' => route('blog'), 'active' => request()->routeIs('blog')],
    ];
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="@yield('meta_description', 'Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas - Pesantren modern berfokus pada tahfidz Al-Qur\'an, pendidikan karakter, dan pembinaan generasi Qur\'ani.')">
    <meta name="keywords"
        content="@yield('meta_keywords', 'pondok pesantren, tahfidz, tahfidzul qur\'an, nurul ikhlas, pesantren modern, pendidikan islam')">
    <meta name="author" content="Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas">
    <meta property="og:title" content="@yield('og_title', trim($__env->yieldContent('title', 'Pondok Pesantren Tahfidzul Qur\'an Nurul Ikhlas')))">
    <meta property="og:description"
        content="@yield('og_description', 'Pesantren tahfidz dengan program unggulan tahfidzul Qur\'an, diniyah, dan pengembangan karakter Islami.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ asset('images/pondok-hero.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">

    <title>@yield('title', 'Nurul Ikhlas | Pondok Pesantren Tahfidzul Qur\'an')</title>

    <link rel="icon" type="image/png" href="{{ asset('logo baru.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>

<body class="antialiased bg-white text-gray-700">
    <x-navbar :navigation="$navigation" />

    <main class="pt-24">
        @yield('content')
    </main>

    <x-footer />

    <x-whatsapp-widget />

    @stack('scripts')
</body>

</html>
