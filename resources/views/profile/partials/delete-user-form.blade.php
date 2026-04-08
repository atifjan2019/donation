<section>
    <header>
        <h5 class="fw-bold text-danger">{{ __('Delete Account') }}</h5>
        <p class="text-muted small mt-1">{{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}</p>
    </header>

    <button type="button" class="btn btn-outline-danger btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
        {{ __('Delete Account') }}
    </button>

    {{-- Modal --}}
    <div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 overflow-hidden">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf @method('delete')
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="deleteAccountModalLabel">Are you sure?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted small">Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.</p>
                        <div class="mt-3">
                            <label for="delete_password" class="form-label fw-semibold small visually-hidden">Password</label>
                            <input id="delete_password" name="password" type="password" class="form-control" placeholder="Your password">
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1" />
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm">Delete Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
