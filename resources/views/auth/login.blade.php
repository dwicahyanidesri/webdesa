<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin &middot; Desa Tanjung Agung</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-sm">
        <div class="text-center mb-6">
            <span class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-emerald-700 text-cream-50 font-display font-semibold text-lg mb-3 shadow-lg shadow-emerald-900/20">TA</span>
            <h1 class="text-xl font-display font-semibold text-emerald-950">Login Superadmin</h1>
            <p class="text-sm text-emerald-900/50">Desa Tanjung Agung</p>
        </div>

        <div class="bg-white rounded-2xl border border-emerald-900/10 p-6 shadow-sm">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Kata Sandi</label>
                    <input type="password" name="password" required
                           class="w-full rounded-lg border-emerald-900/20 focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                </div>
                <label class="flex items-center gap-2 text-sm text-emerald-900/70">
                    <input type="checkbox" name="remember" class="rounded border-emerald-900/20 text-emerald-600 focus:ring-emerald-500">
                    Ingat saya
                </label>
                <button type="submit" class="w-full rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white py-2.5 font-medium">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-sm text-emerald-900/40 mt-6">
            <a href="{{ route('home') }}" class="hover:text-emerald-700">&larr; Kembali ke Beranda</a>
        </p>
    </div>

</body>
</html>
