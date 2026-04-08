<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'DonateHeart — Make a Difference' }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>

    {{-- ── Navbar ─────────────────────────────────────────── --}}
    <nav class="navbar navbar-expand-md navbar-glass sticky-top py-0" x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 20" :class="scrolled && 'scrolled'">
        <div class="container py-2">
            {{-- Logo --}}
            <a href="{{ route('campaigns.index') }}" class="navbar-brand d-flex align-items-center gap-2 py-2">
                <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width:36px;height:36px;background:linear-gradient(135deg,#4f46e5,#4338ca);">
                    <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                </div>
                <span class="fw-bold font-display fs-5">Donate<span class="text-gradient">Heart</span></span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav mx-auto gap-1">
                    <li class="nav-item">
                        <a href="{{ route('campaigns.index') }}" class="nav-link px-3 rounded-3 {{ request()->routeIs('campaigns.index') ? 'active fw-semibold bg-primary bg-opacity-10 text-primary' : '' }}">Campaigns</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('donations.create') }}" class="nav-link px-3 rounded-3 {{ request()->routeIs('donations.create') ? 'active fw-semibold bg-primary bg-opacity-10 text-primary' : '' }}">Donate Now</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}" class="nav-link px-3 rounded-3">My Dashboard</a>
                        </li>
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="nav-link px-3 rounded-3">Admin</a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @guest
                        <a href="{{ route('login') }}" class="btn btn-sm btn-link text-decoration-none fw-medium">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-gradient">Get Started</a>
                    @else
                        <div class="dropdown">
                            <button class="btn btn-sm d-flex align-items-center gap-2 rounded-pill px-2 py-1" data-bs-toggle="dropdown">
                                <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width:32px;height:32px;font-size:12px;background:linear-gradient(135deg,#4f46e5,#4338ca);">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-truncate fw-medium" style="max-width:120px">{{ Auth::user()->name }}</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" style="min-width:220px">
                                <li class="px-3 py-2 border-bottom mb-1">
                                    <div class="fw-bold small">{{ Auth::user()->name }}</div>
                                    <div class="text-muted" style="font-size:11px">{{ Auth::user()->email }}</div>
                                </li>
                                <li><a href="{{ route('dashboard') }}" class="dropdown-item rounded-3 py-2 small">Dashboard</a></li>
                                <li><a href="{{ route('profile.edit') }}" class="dropdown-item rounded-3 py-2 small">Profile</a></li>
                                <li><hr class="dropdown-divider my-1"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">@csrf
                                        <button type="submit" class="dropdown-item rounded-3 py-2 small text-danger">Log Out</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    {{-- Flash messages --}}
    @if(session('status'))
        <div class="container mt-4 animate-fade-up">
            <div class="alert alert-success d-flex align-items-center gap-2 rounded-4 border-0 shadow-sm" role="alert">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('status') }}
            </div>
        </div>
    @endif

    <main>{{ $slot }}</main>

    {{-- ── Footer ──────────────────────────────────────────── --}}
    <footer class="footer-dark mt-5 pt-5 pb-4">
        <div class="footer-orb"></div>
        <div class="container position-relative" style="z-index:2">
            <div class="row g-4 mb-5">
                <div class="col-md-5">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:36px;height:36px;background:linear-gradient(135deg,#4f46e5,#4338ca);">
                            <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                        <span class="fw-bold font-display fs-5 text-white">Donate<span style="color:#818cf8">Heart</span></span>
                    </div>
                    <p class="text-secondary small" style="max-width:320px">Making it easy to support the campaigns that matter most. Every donation creates a ripple of real-world change.</p>
                </div>
                <div class="col-md-3">
                    <h6 class="text-white fw-semibold mb-3">Platform</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('campaigns.index') }}" class="text-secondary text-decoration-none">Browse Campaigns</a></li>
                        <li class="mb-2"><a href="{{ route('donations.create') }}" class="text-secondary text-decoration-none">Donate Now</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h6 class="text-white fw-semibold mb-3">Account</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="{{ route('login') }}" class="text-secondary text-decoration-none">Sign In</a></li>
                        <li class="mb-2"><a href="{{ route('register') }}" class="text-secondary text-decoration-none">Create Account</a></li>
                        @auth <li class="mb-2"><a href="{{ route('dashboard') }}" class="text-secondary text-decoration-none">My Dashboard</a></li> @endauth
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary border-opacity-25 pt-3 d-flex flex-column flex-sm-row align-items-center justify-content-between gap-2" style="font-size:12px;color:#475569">
                <span>&copy; {{ date('Y') }} DonateHeart. All rights reserved.</span>
                <span class="d-flex align-items-center gap-1">Made with <svg class="animate-heart-beat" width="14" height="14" fill="#6366f1" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg> for every donor</span>
            </div>
        </div>
    </footer>
</body>
</html>
