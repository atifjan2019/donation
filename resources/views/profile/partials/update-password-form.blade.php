<section>
    <header>
        <h5 class="fw-bold">{{ __('Update Password') }}</h5>
        <p class="text-muted small mt-1">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf @method('put')
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label fw-semibold small">Current Password</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1" />
        </div>
        <div class="mb-3">
            <label for="update_password_password" class="form-label fw-semibold small">New Password</label>
            <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1" />
        </div>
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label fw-semibold small">Confirm Password</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1" />
        </div>
        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-gradient btn-sm">Save</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-muted small mb-0">Saved.</p>
            @endif
        </div>
    </form>
</section>
