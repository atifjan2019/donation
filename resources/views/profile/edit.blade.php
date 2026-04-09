<x-layouts.public>
    <x-slot:title>Profile — DonateHeart</x-slot:title>

    <div class="container py-5" style="max-width:640px">
        <h2 class="font-display fw-bold mb-4">Profile Settings</h2>

        @if(session('status') === 'profile-updated')
            <div class="alert alert-success rounded-4 border-0 shadow-sm small">Profile updated!</div>
        @endif

        <div class="card mb-4">
            <div class="card-body p-4">
                <h5 class="font-display fw-bold mb-3">Profile Information</h5>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-gradient">Save Changes</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-4">
                <h5 class="font-display fw-bold text-danger mb-3">Delete Account</h5>
                <p class="text-muted small">Once deleted, all data is permanently removed.</p>
                <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure? This cannot be undone.')">
                    @csrf @method('DELETE')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm your password</label>
                        <input type="password" name="password" class="form-control" required>
                        @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <button type="submit" class="btn btn-outline-danger">Delete Account</button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.public>
