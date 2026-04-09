<x-layouts.guest>
    <div class="card-body p-4 p-md-5">
        <h2 class="font-display fw-bold text-center mb-1">Verify your email</h2>
        <p class="text-muted text-center small mb-4">Thanks for signing up! Please verify your email address by clicking the link we sent you.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="alert alert-success rounded-4 border-0 shadow-sm small mb-4">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <x-primary-button>{{ __('Resend Email') }}</x-primary-button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-link text-muted small text-decoration-none">{{ __('Log Out') }}</button>
            </form>
        </div>
    </div>
</x-layouts.guest>
