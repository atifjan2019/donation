<section>
    <header>
        <h5 class="fw-bold">{{ __('Profile Information') }}</h5>
        <p class="text-muted small mt-1">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">@csrf</form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf @method('patch')
        <div class="mb-3">
            <label for="name" class="form-label fw-semibold small">Name</label>
            <input id="name" name="name" type="text" class="form-control" :value="old('name', $user->name)" required autofocus autocomplete="name">
            <x-input-error class="mt-1" :messages="$errors->get('name')" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label fw-semibold small">Email</label>
            <input id="email" name="email" type="email" class="form-control" :value="old('email', $user->email)" required autocomplete="username">
            <x-input-error class="mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2 small text-dark">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification" class="btn btn-link p-0 small text-decoration-underline">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-success small fw-medium">A new verification link has been sent to your email address.</p>
                    @endif
                </div>
            @endif
        </div>
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-gradient btn-sm">Save</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-muted small mb-0">Saved.</p>
            @endif
        </div>
    </form>
</section>
