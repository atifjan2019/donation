<x-guest-layout>
    <div>
        <h2 class="text-2xl font-display font-bold text-gray-900 mb-1">Welcome back</h2>
        <p class="text-sm text-gray-500 mb-8">Sign in to your account to continue giving.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full rounded-xl border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 transition-colors" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium text-brand-600 hover:text-brand-700">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full">Sign In</button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account? <a href="{{ route('register') }}" class="font-medium text-brand-600 hover:text-brand-700">Sign up</a>
        </p>
    </form>
</x-guest-layout>
