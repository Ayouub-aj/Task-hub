<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Task Hub') }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=3">
    <link rel="icon" type="image/svg+xml" sizes="any" href="{{ asset('task-hub-icon-v2.svg') }}?v=4">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}?v=3">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans antialiased">
    <nav class="bg-gradient-to-r from-violet-600 to-indigo-500 text-white shadow-sm">
        <div class="mx-auto flex w-full max-w-6xl items-center justify-between px-4 py-4">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold">Task Hub</a>
            <div class="flex items-center gap-4 text-sm font-medium">
                @auth
                    <a href="{{ route('tasks.index') }}" class="hover:opacity-90">My Tasks</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full bg-white/20 px-4 py-1.5 transition hover:bg-white/30">Logout</button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="hover:opacity-90">Login</a>
                    <a href="{{ route('register') }}" class="rounded-full bg-white/20 px-4 py-1.5 transition hover:bg-white/30">Register</a>
                @endguest
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div class="mx-auto mt-4 w-full max-w-6xl px-4">
            <div class="inline-flex rounded-full bg-emerald-100 px-4 py-2 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mx-auto mt-4 w-full max-w-6xl px-4">
            <div class="inline-flex rounded-full bg-rose-100 px-4 py-2 text-sm font-medium text-rose-700">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <main class="mx-auto w-full max-w-6xl px-4 py-8">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
</body>
</html>
