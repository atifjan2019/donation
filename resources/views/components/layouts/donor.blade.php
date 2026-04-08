<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $header ?? 'My Dashboard' }} — DonateHeart</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
<div x-data="{ sidebarOpen: false }" class="d-flex min-vh-100">

    {{-- Overlay --}}
    <div class="sidebar-overlay" :class="sidebarOpen && 'show'" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside class="sidebar d-flex flex-column" :class="sidebarOpen && 'show'">
        <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom" style="border-color:rgba(255,255,255,0.05)!important">
            <a href="{{ route('campaigns.index') }}" class="d-flex align-items-center gap-2 text-decoration-none">
                <div class="d-flex align-items-center justify-content-center rounded-3" style="width:32px;height:32px;background:linear-gradient(135deg,#818cf8,#4f46e5)">
                    <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <div>
                    <div class="font-display fw-bold text-white small">DonateHeart</div>
                    <div style="font-size:10px;color:rgba(129,140,248,0.6)">Donor Portal</div>
                </div>
            </a>
        </div>

        <nav class="flex-grow-1 px-3 py-4 overflow-auto">
            <div class="sidebar-section-label mb-2">My Account</div>
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') && !request()->is('dashboard/*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                Overview
            </a>
            <a href="{{ route('dashboard.history') }}" class="sidebar-link {{ request()->routeIs('dashboard.history') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Donation History
            </a>
            <a href="{{ route('dashboard.recurring') }}" class="sidebar-link {{ request()->routeIs('dashboard.recurring') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                Recurring
            </a>
            <a href="{{ route('dashboard.receipts') }}" class="sidebar-link {{ request()->routeIs('dashboard.receipts') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Tax Receipts
            </a>

            <div class="pt-3 mt-3 border-top" style="border-color:rgba(255,255,255,0.05)!important">
                <div class="sidebar-section-label mb-2">Quick Actions</div>
                <a href="{{ route('donations.create') }}" class="sidebar-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    Make a Donation
                </a>
                <a href="{{ route('campaigns.index') }}" class="sidebar-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Browse Campaigns
                </a>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
            </div>
        </nav>

        <div class="px-3 py-3 border-top" style="border-color:rgba(255,255,255,0.05)!important">
            <div class="d-flex align-items-center gap-2 px-2 py-2 rounded-3">
                <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width:32px;height:32px;font-size:12px;background:linear-gradient(135deg,#f59e0b,#d97706)">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-grow-1" style="min-width:0">
                    <div class="text-white small fw-semibold text-truncate">{{ Auth::user()->name }}</div>
                    <div class="text-truncate" style="font-size:11px;color:rgba(255,255,255,0.3)">{{ Auth::user()->email }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}">@csrf
                    <button type="submit" class="btn btn-sm p-1 border-0" style="color:rgba(255,255,255,0.25)" title="Log out">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <div class="flex-grow-1 d-flex flex-column" style="min-width:0">
        <header class="topbar-glass d-flex align-items-center px-4 py-3">
            <button @click="sidebarOpen = true" class="btn btn-sm d-lg-none me-3 p-1 text-muted border-0">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                <h1 class="font-display fw-bold fs-6 mb-0">{{ $header ?? 'Dashboard' }}</h1>
                <a href="{{ route('donations.create') }}" class="btn btn-gradient btn-sm d-none d-sm-inline-flex align-items-center gap-1">
                    <svg width="14" height="14" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    Donate
                </a>
            </div>
        </header>

        @if(session('status'))
            <div class="px-4 pt-3 animate-fade-up">
                <div class="alert alert-success d-flex align-items-center gap-2 rounded-4 border-0 shadow-sm small">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('status') }}
                </div>
            </div>
        @endif

        <main class="flex-grow-1 p-4 overflow-auto">{{ $slot }}</main>
    </div>
</div>
</body>
</html>
