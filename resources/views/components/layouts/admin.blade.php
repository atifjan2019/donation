<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $header ?? 'Dashboard' }} — Admin · DonateHeart</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
<div x-data="{ sidebarOpen: false }" class="d-flex min-vh-100">

    <div class="sidebar-overlay" :class="sidebarOpen && 'show'" @click="sidebarOpen = false"></div>

    <aside class="sidebar d-flex flex-column" :class="sidebarOpen && 'show'" style="background:linear-gradient(180deg,#0f172a 0%,#0a0f1c 100%)">
        <div class="d-flex align-items-center gap-3 px-4 py-3 border-bottom" style="border-color:rgba(255,255,255,0.05)!important">
            <div class="d-flex align-items-center justify-content-center rounded-3" style="width:32px;height:32px;background:linear-gradient(135deg,#818cf8,#4f46e5)">
                <svg width="16" height="16" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <div>
                <div class="font-display fw-bold text-white small">DonateHeart</div>
                <div class="fw-semibold text-uppercase" style="font-size:10px;color:rgba(251,191,36,0.6);letter-spacing:0.12em">Admin</div>
            </div>
        </div>

        <nav class="flex-grow-1 px-3 py-4 overflow-auto">
            <div class="sidebar-section-label mb-2">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4"/></svg>
                Dashboard
            </a>
            <a href="{{ route('admin.donations.index') }}" class="sidebar-link {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/></svg>
                Donations
            </a>
            <a href="{{ route('admin.campaigns.index') }}" class="sidebar-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Campaigns
            </a>
            <div class="pt-3 mt-3 border-top" style="border-color:rgba(255,255,255,0.05)!important">
                <div class="sidebar-section-label mb-2">Account</div>
                <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zm-4 7a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profile
                </a>
                <a href="{{ route('campaigns.index') }}" class="sidebar-link">
                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Public Site
                </a>
            </div>
        </nav>

        <div class="px-3 py-3 border-top" style="border-color:rgba(255,255,255,0.05)!important">
            <div class="d-flex align-items-center gap-2 px-2 py-2 rounded-3">
                <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width:32px;height:32px;font-size:12px;background:linear-gradient(135deg,#818cf8,#4f46e5)">
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

    <div class="flex-grow-1 d-flex flex-column" style="min-width:0">
        <header class="topbar-glass d-flex align-items-center px-4 py-3">
            <button @click="sidebarOpen = true" class="btn btn-sm d-lg-none me-3 p-1 text-muted border-0">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="d-flex align-items-center justify-content-between flex-grow-1">
                <h1 class="font-display fw-bold fs-6 mb-0">{{ $header ?? 'Dashboard' }}</h1>
                <span class="text-muted small d-none d-sm-block">{{ now()->format('l, F j') }}</span>
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
