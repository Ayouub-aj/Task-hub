<x-guest-layout>
    <div class="w-full max-w-md rounded-xl bg-white p-8 shadow-md">
        <h1 class="mb-6 text-center text-2xl font-semibold text-slate-800">Create Account</h1>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="mb-1 block text-sm font-medium text-slate-700">Name</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('name')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('email')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                <input id="password" name="password" type="password" required autocomplete="new-password" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('password')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirm" class="mb-1 block text-sm font-medium text-slate-700">Confirm Password</label>
                <input id="password_confirm" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200">
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full rounded-full bg-gradient-to-r from-violet-600 to-indigo-500 px-4 py-2 font-medium text-white transition hover:opacity-95">
                Register
            </button>
        </form>
    </div>
</x-guest-layout>
