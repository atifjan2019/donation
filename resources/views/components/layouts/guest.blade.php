<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DonateHeart') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="min-vh-100 d-flex align-items-center justify-content-center" style="background:linear-gradient(135deg,#1f2937 0%,#32373c 50%,#4b5563 100%)">
        <div class="hero-orb" style="width:500px;height:500px;top:-200px;right:-100px;background:rgba(219,124,28,0.12)"></div>
        <div class="hero-orb" style="width:400px;height:400px;bottom:-100px;left:-50px;background:rgba(39,174,96,0.08)"></div>

        <div class="w-100 position-relative" style="max-width:420px;z-index:2;padding:1.5rem">
            <div class="text-center mb-4 animate-fade-up">
                <a href="{{ route('campaigns.index') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                    <div class="d-flex align-items-center justify-content-center rounded-3 shadow" style="width:44px;height:44px;background:linear-gradient(135deg,#DB7C1C,#c46c14)">
                        <svg width="24" height="24" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <span class="fw-bold font-display fs-4 text-white">Donate<span style="color:#DB7C1C">Heart</span></span>
                </a>
            </div>

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden animate-fade-up" style="animation-delay:0.1s">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
