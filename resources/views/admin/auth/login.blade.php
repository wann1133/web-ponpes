<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Admin | Nurul Ikhlas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $logoPath = null;
    foreach (['logo baru.png', 'logo.svg', 'logoo.jpg', 'logoo.png'] as $logoCandidate) {
        if (file_exists(public_path($logoCandidate))) {
            $logoPath = asset($logoCandidate);
            break;
        }
    }
@endphp

<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-pondok-primary/5 via-white to-pondok-secondary/10">
    <div class="w-full max-w-md rounded-3xl bg-white p-8 shadow-xl">
        <div class="text-center">
            @if ($logoPath)
                <img src="{{ $logoPath }}" alt="Logo Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas"
                    class="mx-auto mb-4 h-10 w-10 object-contain">
            @endif
            <p class="text-xs font-semibold uppercase tracking-[0.3em] text-pondok-primary">Panel Admin</p>
            <p class="mt-1 text-sm text-slate-500">Silakan masuk menggunakan akun admin pesantren.</p>
        </div>

        <form class="mt-8 space-y-5" method="POST" action="{{ route('admin.login.store') }}">
            @csrf

            <div class="space-y-1">
                <label for="email" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                @error('email')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label for="password" class="text-xs font-semibold uppercase tracking-wide text-slate-500">Kata Sandi</label>
                <input id="password" name="password" type="password" required
                    class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm shadow-sm focus:border-pondok-primary focus:ring-pondok-primary">
                @error('password')
                    <p class="text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center gap-2 text-slate-500">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-pondok-primary focus:ring-pondok-primary">
                    Ingat saya
                </label>
            </div>

            @if ($errors->has('email') && ! $errors->has('password'))
                <p class="text-xs text-red-500">{{ $errors->first('email') }}</p>
            @endif

            <button type="submit"
                class="w-full rounded-xl bg-pondok-primary px-4 py-2.5 text-sm font-semibold text-white shadow-soft transition hover:bg-pondok-secondary">
                Masuk
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-400">
            &copy; {{ now()->year }} Pondok Pesantren Tahfidzul Qur'an Nurul Ikhlas.
        </p>
    </div>
</body>

</html>
