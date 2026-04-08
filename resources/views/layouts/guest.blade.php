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
<div class="d-flex min-vh-100">

    {{-- Left panel --}}
    <div class="d-none d-lg-flex hero-gradient position-relative overflow-hidden" style="width:45%">
        <div class="hero-pattern"></div>
        <div class="hero-orb animate-float" style="width:320px;height:320px;top:-100px;right:-80px;background:rgba(99,102,241,0.1)"></div>
        <div class="hero-orb animate-float" style="width:400px;height:400px;bottom:-150px;left:-100px;background:rgba(245,158,11,0.08);animation-delay:1s"></div>

        {{-- Floating cards --}}
        <div class="glass-dark rounded-4 p-3 text-white position-absolute animate-float" style="top:60px;right:40px;border:1px solid rgba(255,255,255,0.1)">
            <div style="font-size:11px;color:rgba(255,255,255,0.45)">Total Raised</div>
            <div class="font-display fw-bold fs-4 mt-1">$2.4M+</div>
        </div>
        <div class="glass-dark rounded-4 p-3 text-white position-absolute animate-float" style="bottom:100px;right:50px;border:1px solid rgba(255,255,255,0.1);animation-delay:1.5s">
            <div style="font-size:11px;color:rgba(255,255,255,0.45)">Happy Donors</div>
            <div class="font-display fw-bold fs-4 mt-1">12,500+</div>
        </div>

        <div class="d-flex flex-column justify-content-center px-5 py-5 position-relative" style="z-index:5">
            <div class="d-flex align-items-center gap-3 mb-5">
                <div class="d-flex align-items-center justify-content-center rounded-3 shadow" style="width:44px;height:44px;background:linear-gradient(135deg,#818cf8,#4f46e5)">
                    <svg width="24" height="24" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <span class="font-display fw-bold fs-4 text-white">DonateHeart</span>
            </div>

            <h2 class="font-display fw-bold text-white display-5 mb-4" style="line-height:1.1">
                Every donation<br>creates a<br><span class="text-gradient">ripple of change.</span>
            </h2>
            <p class="lead" style="color:rgba(199,210,254,0.6);max-width:360px">
                Join thousands of generous donors making a real difference in people's lives around the world.
            </p>
            <div class="d-flex flex-column gap-3 mt-4">
                @foreach(['Verified campaigns with transparent goals','Secure payments via Stripe & PayPal','Instant tax receipts for every donation'] as $t)
                    <div class="d-flex align-items-center gap-2 small" style="color:rgba(255,255,255,0.6)">
                        <span class="d-flex align-items-center justify-content-center rounded-circle" style="width:24px;height:24px;background:rgba(99,102,241,0.2);font-size:11px;color:#a5b4fc">✓</span>
                        {{ $t }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="flex-grow-1 d-flex flex-column justify-content-center align-items-center p-4 p-lg-5" style="background:#fafbfd">
        <div class="d-lg-none d-flex align-items-center gap-2 mb-4">
            <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width:36px;height:36px;background:linear-gradient(135deg,#4f46e5,#4338ca)">
                <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <span class="font-display fw-bold fs-5">Donate<span class="text-gradient">Heart</span></span>
        </div>
        <div class="w-100 animate-fade-up" style="max-width:420px">
            {{ $slot }}
        </div>
    </div>

</div>
</body>
</html>
