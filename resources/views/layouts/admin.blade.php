<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin Dashboard' }} - DonateHeart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex">
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 bg-black/30 z-40 lg:hidden"></div>

        {{-- Sidebar --}}
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform transition-transform duration-200 lg:translate-x-0 lg:static lg:inset-auto lg:z-auto flex flex-col">
            {{-- Logo --}}
            <div class="flex items-center gap-2 px-6 h-16 border-b border-gray-100 shrink-0">
                <svg class="w-7 h-7 text-brand-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                <span class="text-lg font-display font-bold text-gray-900">Admin</span>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                   class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.donations.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.donations.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                    Donations
                </a>
                <a href="{{ route('admin.campaigns.index') }}"
                   class="sidebar-link {{ request()->routeIs('admin.campaigns.*') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    Campaigns
                </a>

                <div class="pt-6 mt-6 border-t border-gray-100">
                    <p class="px-4 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Account</p>
                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-link {{ request()->routeIs('profile.edit') ? 'sidebar-link-active' : 'sidebar-link-inactive' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profile
                    </a>
                    <a href="{{ route('campaigns.index') }}"
                       class="sidebar-link sidebar-link-inactive">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        View Site
                    </a>
                </div>
            </nav>

            {{-- User info --}}
            <div class="px-4 py-4 border-t border-gray-100 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-brand-100 text-brand-700 rounded-full flex items-center justify-center font-semibold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-1.5 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100" title="Log out">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-200 h-16 flex items-center px-4 sm:px-6 lg:px-8 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 -ml-2 mr-3 text-gray-500 hover:bg-gray-100 rounded-lg">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg font-display font-semibold text-gray-900">{{ $header ?? 'Dashboard' }}</h1>
            </header>

            {{-- Flash messages --}}
            @if(session('status'))
                <div class="mx-4 sm:mx-6 lg:mx-8 mt-4">
                    <div class="bg-accent-50 border border-accent-200 text-accent-800 px-4 py-3 rounded-xl text-sm">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            {{-- Page --}}
            <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
