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
            {{-- Left decorative panel --}}
            <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-brand-600 via-brand-700 to-accent-800 relative overflow-hidden">
                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full" viewBox="0 0 400 400" fill="none"><circle cx="200" cy="200" r="200" fill="white"/><circle cx="100" cy="100" r="100" fill="white"/><circle cx="320" cy="350" r="80" fill="white"/></svg>
                </div>
                <div class="relative z-10 flex flex-col justify-center px-12 xl:px-20">
                    <div class="flex items-center gap-3 mb-8">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span class="text-2xl font-display font-bold text-white">DonateHeart</span>
                    </div>
                    <h2 class="text-3xl xl:text-4xl font-display font-bold text-white leading-tight mb-4">Every donation<br/>creates a ripple<br/>of change.</h2>
                    <p class="text-brand-100 text-lg max-w-md">Join thousands of generous donors making a real difference in people's lives.</p>
                </div>
            </div>

            {{-- Right form panel --}}
            <div class="flex-1 flex flex-col justify-center items-center px-6 py-12 bg-gray-50">
                <div class="lg:hidden flex items-center gap-2 mb-8">
                    <svg class="w-8 h-8 text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span class="text-xl font-display font-bold text-gray-900">DonateHeart</span>
                </div>
                <div class="w-full max-w-md">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
