<x-layouts.guest>
    <div class="mb-4">
        <h2 class="font-display fw-bold fs-3">Reset your password</h2>
        <p class="text-muted small">Choose a new password for your account.</p>
    </div>
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username" class="form-control">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold small">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold small">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-3">Reset Password</button>
    </form>
</x-layouts.guest>
