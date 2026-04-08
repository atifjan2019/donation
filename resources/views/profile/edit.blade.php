<x-layouts.donor>
    <x-slot:header>Profile Settings</x-slot:header>

    <div style="max-width:640px">
        <div class="card p-4 p-md-5 mb-4">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="card p-4 p-md-5 mb-4">
            @include('profile.partials.update-password-form')
        </div>
        <div class="card p-4 p-md-5" style="border-color:rgba(239,68,68,0.15)">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-layouts.donor>
