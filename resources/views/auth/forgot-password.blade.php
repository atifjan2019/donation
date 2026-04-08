<x-layouts.guest>
    <div class="mb-4">
        <h2 class="font-display fw-bold fs-3">Forgot your password?</h2>
        <p class="text-muted small">No problem. Enter your email and we'll send you a reset link.</p>
    </div>
    <x-auth-session-status class="mb-3" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label fw-semibold small">Email address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus class="form-control" placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-3">Email Password Reset Link</button>
    </form>
</x-layouts.guest>
