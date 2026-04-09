<x-layouts.guest>
    <div class="card-body p-4 p-md-5">
        <h2 class="font-display fw-bold text-center mb-1">Forgot password?</h2>
        <p class="text-muted text-center small mb-4">Enter your email and we'll send you a reset link.</p>

        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <x-primary-button class="w-100 py-2 justify-content-center">
                {{ __('Send Reset Link') }}
            </x-primary-button>

            <p class="text-center text-muted small mt-4 mb-0">
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Back to sign in</a>
            </p>
        </form>
    </div>
</x-layouts.guest>
