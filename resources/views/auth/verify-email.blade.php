<x-layouts.guest>
    <div class="mb-3">
        <h2 class="font-display fw-bold fs-4">Verify your email</h2>
        <p class="text-muted small">Thanks for signing up! Before getting started, could you verify your email address by clicking the link we just emailed to you?</p>
    </div>
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success rounded-4 border-0 small mb-3">A new verification link has been sent to your email.</div>
    @endif
    <div class="d-flex align-items-center justify-content-between">
        <form method="POST" action="{{ route('verification.send') }}">@csrf
            <button type="submit" class="btn btn-gradient btn-sm">Resend Verification Email</button>
        </form>
        <form method="POST" action="{{ route('logout') }}">@csrf
            <button type="submit" class="btn btn-link text-muted small text-decoration-none">Log Out</button>
        </form>
    </div>
</x-layouts.guest>
