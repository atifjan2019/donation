<x-layouts.guest>
    <div class="mb-4">
        <h2 class="font-display fw-bold fs-3">Create your account</h2>
        <p class="text-muted small">Join our community and start making a difference today.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold small">Full name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="form-control" placeholder="John Doe">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" class="form-control" placeholder="you@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold small">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" class="form-control" placeholder="Choose a strong password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-semibold small">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="form-control" placeholder="Repeat your password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>
        <button type="submit" class="btn btn-gradient w-100 py-3 mb-3">Create Account</button>
        <p class="text-center text-muted small">
            Already have an account? <a href="{{ route('login') }}" class="text-primary fw-semibold text-decoration-none">Sign in</a>
        </p>
    </form>
</x-layouts.guest>
