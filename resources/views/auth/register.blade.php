<x-layouts.guest>
    <div class="card-body p-4 p-md-5">
        <h2 class="font-display fw-bold text-center mb-1">Create your account</h2>
        <p class="text-muted text-center small mb-4">Join DonateHeart and start making a difference</p>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" />
            </div>

            <div class="mb-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <div class="mb-3">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" />
            </div>

            <x-primary-button class="w-100 py-2 justify-content-center">
                {{ __('Create Account') }}
            </x-primary-button>

            <p class="text-center text-muted small mt-4 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Sign in</a>
            </p>
        </form>
    </div>
</x-layouts.guest>
