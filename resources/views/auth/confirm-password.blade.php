<x-layouts.guest>
    <div class="mb-3">
        <h2 class="font-display fw-bold fs-4">Confirm password</h2>
        <p class="text-muted small">This is a secure area. Please confirm your password before continuing.</p>
    </div>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-4">
            <label for="password" class="form-label fw-semibold small">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-3">Confirm</button>
    </form>
</x-layouts.guest>
