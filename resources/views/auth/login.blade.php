<x-layouts.guest>
    <div class="card-body p-4 p-md-5">
        <h2 class="font-display fw-bold text-center mb-1">Welcome back</h2>
        <p class="text-muted text-center small mb-4">Sign in to your DonateHeart account</p>

        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="form-check">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label for="remember_me" class="form-check-label small">{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="text-decoration-none small fw-medium" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-primary-button class="w-100 py-2 justify-content-center">
                {{ __('Sign In') }}
            </x-primary-button>

            <p class="text-center text-muted small mt-4 mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Create one</a>
            </p>
        </form>
    </div>
</x-layouts.guest>
