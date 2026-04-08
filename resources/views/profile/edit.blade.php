<x-layouts.donor>
    <x-slot:header>Profile Settings</x-slot:header>

    <div class="max-w-2xl space-y-6">
        <div class="card p-6 md:p-8">
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="card p-6 md:p-8">
            @include('profile.partials.update-password-form')
        </div>

        <div class="card p-6 md:p-8 border-red-100">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-layouts.donor>
