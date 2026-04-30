<x-guest-layout>
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-md">
        <h1 class="mb-6 text-center text-2xl font-semibold text-slate-800">Welcome Back</h1>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('email')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('password')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                Remember me
            </label>

            <button type="submit" class="w-full rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-4 py-2 font-medium text-white transition hover:opacity-95">
                Log In
            </button>
        </form>
    </div>
</x-guest-layout>
