<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'DonateHeart — Make a Difference' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">

    {{-- ── Navbar ─────────────────────────────────────────── --}}
    <nav x-data="{ mobileOpen: false }" class="bg-white/90 backdrop-blur-lg border-b border-gray-100 sticky top-0 z-50 shadow-sm shadow-gray-100/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                {{-- Logo --}}
                <a href="{{ route('campaigns.index') }}" class="flex items-center gap-2.5 group">
                    <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-700 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-brand-200 transition-shadow">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <span class="text-xl font-display font-bold text-gray-900">Donate<span class="text-brand-600">Heart</span></span>
                </a>

                {{-- Desktop nav --}}
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('campaigns.index') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('campaigns.index') ? 'text-brand-600 bg-brand-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Campaigns
                    </a>
                    <a href="{{ route('donations.create') }}"
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('donations.create') ? 'text-brand-600 bg-brand-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                        Donate Now
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                            My Dashboard
                        </a>
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 rounded-lg text-sm font-medium text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                                Admin
                            </a>
                        @endif
                    @endauth
                </div>

                {{-- Auth area --}}
                <div class="hidden md:flex items-center gap-3">
                    @guest
                        <a href="{{ route('login') }}"
                           class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors px-3 py-2">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="btn-primary !py-2 !px-5 text-sm">
                            Get Started
                        </a>
                    @else
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open"
                                    class="flex items-center gap-2.5 pl-1 pr-3 py-1 rounded-full hover:bg-gray-100 transition-colors text-sm font-medium text-gray-700">
                                <div class="w-8 h-8 bg-gradient-to-br from-brand-500 to-brand-700 text-white rounded-full flex items-center justify-center font-bold text-xs shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                                <svg class="w-3.5 h-3.5 text-gray-400 transition-transform" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-150"
                                 x-transition:enter-start="opacity-0 translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-100"
                                 x-transition:leave-start="opacity-100 translate-y-0"
                                 x-transition:leave-end="opacity-0 translate-y-1"
                                 class="absolute right-0 mt-2 w-52 bg-white rounded-2xl shadow-xl shadow-gray-200/80 border border-gray-100 py-1.5 z-50">
                                <div class="px-4 py-2 border-b border-gray-50 mb-1">
                                    <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                                </div>
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profile
                                </a>
                                <div class="border-t border-gray-50 mt-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endguest
                </div>

                {{-- Mobile hamburger --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-xl text-gray-500 hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden border-t border-gray-100 bg-white/95 backdrop-blur-sm">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('campaigns.index') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Campaigns</a>
                <a href="{{ route('donations.create') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Donate Now</a>
                @auth
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">My Dashboard</a>
                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">@csrf
                        <button type="submit" class="w-full text-left px-3 py-2.5 rounded-xl text-sm font-medium text-red-600 hover:bg-red-50">Log Out</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50">Sign In</a>
                    <a href="{{ route('register') }}" class="flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-medium bg-brand-600 text-white">Get Started</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('status'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-5">
            <div class="alert-success">
                <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
        </div>
    @endif

    <main>{{ $slot }}</main>

    {{-- ── Footer ──────────────────────────────────────────── --}}
    <footer class="bg-gray-950 text-gray-400 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-10">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 mb-12">
                {{-- Brand --}}
                <div class="md:col-span-5">
                    <div class="flex items-center gap-2.5 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-brand-500 to-brand-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                        </div>
                        <span class="text-xl font-display font-bold text-white">Donate<span class="text-brand-500">Heart</span></span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-xs text-gray-500">
                        Making it easy to support the campaigns that matter most. Every donation creates a ripple of real-world change.
                    </p>
                </div>

                {{-- Links --}}
                <div class="md:col-span-3">
                    <h4 class="text-white text-sm font-semibold mb-4">Platform</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('campaigns.index') }}" class="hover:text-white transition-colors">Browse Campaigns</a></li>
                        <li><a href="{{ route('donations.create') }}" class="hover:text-white transition-colors">Donate Now</a></li>
                    </ul>
                </div>

                <div class="md:col-span-4">
                    <h4 class="text-white text-sm font-semibold mb-4">Account</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Sign In</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-white transition-colors">Create Account</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">My Dashboard</a></li>
                        @endauth
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-600">
                <span>&copy; {{ date('Y') }} DonateHeart. All rights reserved.</span>
                <span class="flex items-center gap-1">Made with <svg class="w-3.5 h-3.5 text-brand-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg> for every donor</span>
            </div>
        </div>
    </footer>
</body>
</html>
