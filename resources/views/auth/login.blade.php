<x-layouts.guest>
    <div class="mb-4">
        <h2 class="font-display fw-bold fs-3">Welcome back</h2>
        <p class="text-muted small">Sign in to your DonateHeart account.</p>
    </div>

    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control" placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold small">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" placeholder="••••••••">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="form-check">
                <input id="remember_me" type="checkbox" name="remember" class="form-check-input">
                <label for="remember_me" class="form-check-label small text-muted">Remember me</label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-primary fw-semibold small text-decoration-none">Forgot password?</a>
            @endif
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-3 mb-3">Sign In</button>
        <p class="text-center text-muted small">
            Don't have an account? <a href="{{ route('register') }}" class="text-primary fw-semibold text-decoration-none">Create one</a>
        </p>
    </form>
</x-layouts.guest>
