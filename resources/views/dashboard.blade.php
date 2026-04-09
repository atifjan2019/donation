<x-layouts.public>
    <x-slot:title>Dashboard — DonateHeart</x-slot:title>
    <div class="container py-5 text-center">
        <h1 class="font-display fw-bold">Welcome back, {{ Auth::user()->name }}</h1>
        <p class="text-muted">Go to your <a href="{{ route('dashboard') }}">donor dashboard</a>.</p>
    </div>
</x-layouts.public>
