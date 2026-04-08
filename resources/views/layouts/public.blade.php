<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'DonateHeart - Make a Difference' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    {{-- Navbar --}}
    <nav x-data="{ mobileOpen: false }" class="bg-white/80 backdrop-blur-lg border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('campaigns.index') }}" class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    <span class="text-xl font-display font-bold text-gray-900">Donate<span class="text-brand-600">Heart</span></span>
                </a>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('campaigns.index') }}" class="text-sm font-medium {{ request()->routeIs('campaigns.index') ? 'text-brand-600' : 'text-gray-600 hover:text-gray-900' }} transition-colors">Campaigns</a>
                    <a href="{{ route('donations.create') }}" class="text-sm font-medium {{ request()->routeIs('donations.create') ? 'text-brand-600' : 'text-gray-600 hover:text-gray-900' }} transition-colors">Donate Now</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Dashboard</a>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Admin</a>
                        @endif
                    @endauth
                </div>

                {{-- Auth buttons --}}
                <div class="hidden md:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Sign In</a>
                        <a href="{{ route('register') }}" class="btn-primary text-sm !py-2 !px-4">Sign Up</a>
                    @else
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                                <div class="w-8 h-8 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center font-semibold text-xs">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                                {{ Auth::user()->name }}
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 py-2 z-50">
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Dashboard</a>
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Profile</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                {{-- Mobile hamburger --}}
                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen" x-transition class="md:hidden border-t border-gray-100 bg-white">
            <div class="px-4 py-4 space-y-2">
                <a href="{{ route('campaigns.index') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Campaigns</a>
                <a href="{{ route('donations.create') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Donate Now</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Profile</a>
                    <form method="POST" action="{{ route('logout') }}"><@csrf<button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Log Out</button></form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50">Sign In</a>
                    <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg text-sm font-medium text-brand-600 hover:bg-brand-50">Sign Up</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash success --}}
    @if(session('status'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-accent-50 border border-accent-200 text-accent-800 px-4 py-3 rounded-xl text-sm">
                {{ session('status') }}
            </div>
        </div>
    @endif

    {{-- Page content --}}
    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-900 text-gray-400 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-7 h-7 text-brand-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        <span class="text-lg font-display font-bold text-white">Donate<span class="text-brand-500">Heart</span></span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-sm">Making it easy to support campaigns that matter. Every donation counts towards building a better world.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3 text-sm">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-white transition-colors">Campaigns</a></li>
                        <li><a href="{{ route('donations.create') }}" class="hover:text-white transition-colors">Donate Now</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-3 text-sm">Account</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Create Account</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-10 pt-6 text-center text-xs">
                &copy; {{ date('Y') }} DonateHeart. All rights reserved.
            </div>
        </div>
    </footer>
</body>
</html>
