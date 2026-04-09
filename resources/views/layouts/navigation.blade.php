<nav class="navbar navbar-expand-md navbar-glass sticky-top py-0" x-data="{ scrolled: false }" @scroll.window="scrolled = window.scrollY > 20" :class="scrolled && 'scrolled'">
    <div class="container py-2">
        <a href="{{ route('campaigns.index') }}" class="navbar-brand d-flex align-items-center gap-2 py-2">
            <div class="d-flex align-items-center justify-content-center rounded-3 shadow-sm" style="width:36px;height:36px;background:linear-gradient(135deg,#DB7C1C,#c46c14);">
                <svg width="20" height="20" fill="#fff" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            </div>
            <span class="fw-bold font-display fs-5">Donate<span class="text-gradient">Heart</span></span>
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#appNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="appNav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link px-3 rounded-3 {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                </li>
            </ul>

            <div class="d-flex align-items-center gap-2 ms-3">
                <div class="dropdown" x-data="{ open: false }">
                    <button @click="open = !open" class="btn btn-sm d-flex align-items-center gap-2 rounded-pill px-2 py-1">
                        <div class="d-flex align-items-center justify-content-center rounded-circle text-white fw-bold" style="width:32px;height:32px;font-size:12px;background:linear-gradient(135deg,#DB7C1C,#c46c14)">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <span class="text-truncate fw-medium d-none d-sm-inline" style="max-width:120px">{{ Auth::user()->name }}</span>
                    </button>
                    <div x-show="open" @click.outside="open = false" class="dropdown-menu dropdown-menu-end show shadow-lg border-0 rounded-4 mt-2 p-2">
                        <a href="{{ route('profile.edit') }}" class="dropdown-item rounded-3 py-2 small">Profile</a>
                        <hr class="dropdown-divider my-1">
                        <form method="POST" action="{{ route('logout') }}">@csrf
                            <button type="submit" class="dropdown-item rounded-3 py-2 small text-danger">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
