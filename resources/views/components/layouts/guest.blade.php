<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'DonateHeart') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex">

    {{-- ── Left decorative panel ────────────────────────────── --}}
    <div class="hidden lg:flex lg:w-[45%] xl:w-1/2 relative overflow-hidden bg-gradient-to-br from-brand-700 via-brand-600 to-accent-700">
        {{-- Geometric decorations --}}
        <div class="absolute inset-0">
            <div class="absolute top-0 right-0 w-80 h-80 bg-white/5 rounded-full -translate-y-1/3 translate-x-1/3"></div>
            <div class="absolute bottom-0 left-0 w-96 h-96 bg-black/10 rounded-full translate-y-1/2 -translate-x-1/4"></div>
            <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white/5 rounded-full -translate-x-1/2 -translate-y-1/2 scale-150"></div>
        </div>

        {{-- Floating stats --}}
        <div class="absolute top-16 right-10 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-white">
            <p class="text-xs text-white/70 mb-1">Total Raised</p>
            <p class="text-2xl font-display font-bold">$2.4M+</p>
        </div>
        <div class="absolute bottom-24 right-12 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 text-white">
            <p class="text-xs text-white/70 mb-1">Happy Donors</p>
            <p class="text-2xl font-display font-bold">12,500+</p>
        </div>

        {{-- Main content --}}
        <div class="relative z-10 flex flex-col justify-center px-10 xl:px-16 py-16">
            <div class="flex items-center gap-3 mb-10">
                <div class="w-11 h-11 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <span class="text-2xl font-display font-bold text-white">DonateHeart</span>
            </div>

            <h2 class="text-4xl xl:text-5xl font-display font-bold text-white leading-[1.15] mb-6">
                Every donation<br/>
                creates a<br/>
                <span class="text-brand-200">ripple of change.</span>
            </h2>

            <p class="text-brand-100 text-lg leading-relaxed max-w-sm mb-10">
                Join thousands of generous donors making a real difference in people's lives around the world.
            </p>

            {{-- Trust indicators --}}
            <div class="flex flex-col gap-3">
                @foreach ([['✓', 'Verified campaigns with transparent goals'], ['✓', 'Secure payments via Stripe & PayPal'], ['✓', 'Instant tax receipts for every donation']] as $item)
                    <div class="flex items-center gap-3 text-white/80 text-sm">
                        <span class="w-5 h-5 bg-white/20 rounded-full flex items-center justify-center text-xs font-bold text-white shrink-0">{{ $item[0] }}</span>
                        {{ $item[1] }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ── Right form panel ─────────────────────────────────── --}}
    <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-white">
        {{-- Mobile logo --}}
        <div class="lg:hidden flex items-center gap-2.5 mb-8">
            <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-700 rounded-xl flex items-center justify-center shadow-sm">
                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </div>
            <span class="text-xl font-display font-bold text-gray-900">Donate<span class="text-brand-600">Heart</span></span>
        </div>

        <div class="w-full max-w-md">
            {{ $slot }}
        </div>
    </div>

</div>
</body>
</html>
