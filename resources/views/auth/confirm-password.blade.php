<x-layouts.guest>
    <div class="card-body p-4 p-md-5">
        <h2 class="font-display fw-bold text-center mb-1">Confirm password</h2>
        <p class="text-muted text-center small mb-4">Please confirm your password before continuing.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" />
            </div>

            <x-primary-button class="w-100 py-2 justify-content-center">
                {{ __('Confirm') }}
            </x-primary-button>
        </form>
    </div>
</x-layouts.guest>
