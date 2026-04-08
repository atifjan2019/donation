<x-layouts.guest>
    <div class="mb-8">
        <h2 class="text-3xl font-display font-bold text-gray-900 leading-tight">Welcome back</h2>
        <p class="text-gray-500 mt-2 text-sm">Sign in to continue your giving journey.</p>
    </div>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   required autofocus autocomplete="username"
                   class="form-input" placeholder="you@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="form-label !mb-0">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                        Forgot password?
                    </a>
                @endif
            </div>
            <input id="password" type="password" name="password"
                   required autocomplete="current-password"
                   class="form-input" placeholder="Your password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <label class="flex items-center gap-2.5 cursor-pointer">
            <input id="remember_me" type="checkbox" name="remember"
                   class="w-4 h-4 rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-500">
            <span class="text-sm text-gray-600">Remember me for 30 days</span>
        </label>

        <button type="submit" class="btn-primary w-full !py-3.5 text-base mt-1">
            Sign In
        </button>

        <p class="text-center text-sm text-gray-500">
            Don't have an account?
            <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                Create one free
            </a>
        </p>
    </form>
</x-layouts.guest>
