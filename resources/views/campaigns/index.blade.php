<x-layouts.public>
    <x-slot:title>Campaigns — DonateHeart</x-slot:title>

    {{-- ── Hero ─────────────────────────────────────────────── --}}
    <section class="hero-gradient py-5">
        <div class="hero-pattern"></div>
        <div class="hero-orb" style="width:500px;height:500px;top:-200px;right:-100px;background:rgba(219,124,28,0.12)"></div>
        <div class="hero-orb" style="width:400px;height:400px;bottom:-100px;left:-50px;background:rgba(39,174,96,0.08)"></div>

        <div class="container position-relative py-5" style="z-index:2">
            <div class="animate-fade-up mb-3" style="animation-delay:0.1s">
                <span class="badge rounded-pill px-3 py-2 d-inline-flex align-items-center gap-1" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.1);color:#fff;font-size:11px;letter-spacing:0.08em">
                    <svg class="animate-heart-beat" width="12" height="12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    DONATION PORTAL
                </span>
            </div>
            <h1 class="display-4 font-display fw-bold text-white mb-3 animate-fade-up" style="animation-delay:0.2s;max-width:720px;line-height:1.1">
                Fund causes that matter,<br class="d-none d-md-block">
                <span class="text-gradient">track every milestone.</span>
            </h1>
            <p class="lead animate-fade-up" style="animation-delay:0.35s;color:rgba(219,124,28,0.5);max-width:520px">
                Choose a campaign, donate in minutes, and see your impact grow over time.
            </p>

            <div class="d-none d-lg-flex gap-3 mt-4 animate-fade-up" style="animation-delay:0.5s">
                <div class="glass-dark rounded-4 px-4 py-3">
                    <div style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:600;letter-spacing:0.1em">CAMPAIGNS</div>
                    <div class="text-white font-display fw-bold fs-4 mt-1">{{ $campaigns->total() }}+</div>
                </div>
                <div class="glass-dark rounded-4 px-4 py-3">
                    <div style="font-size:11px;color:rgba(255,255,255,0.4);font-weight:600;letter-spacing:0.1em">TRUSTED</div>
                    <div class="text-white font-display fw-bold fs-4 mt-1">100%</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Campaigns grid ───────────────────────────────────── --}}
    <section class="container py-5">
        <div class="d-flex align-items-center justify-content-between mb-4 animate-fade-up">
            <div>
                <h2 class="font-display fw-bold mb-1">Active Campaigns</h2>
                <p class="text-muted small mb-0">{{ $campaigns->total() }} {{ Str::plural('campaign', $campaigns->total()) }} available</p>
            </div>
            <a href="{{ route('donations.create') }}" class="btn btn-gradient d-none d-sm-inline-flex align-items-center gap-2">
                <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                Donate Now
            </a>
        </div>

        @if($campaigns->count() === 0)
            <div class="card border-2 border-dashed text-center p-5 animate-fade-up">
                <div class="d-flex align-items-center justify-content-center rounded-4 mx-auto mb-3" style="width:64px;height:64px;background:linear-gradient(135deg,#fef3e2,#fef9f0)">
                    <svg width="32" height="32" fill="none" stroke="#DB7C1C" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h4 class="font-display fw-bold">No campaigns yet</h4>
                <p class="text-muted mx-auto" style="max-width:360px">New campaigns will appear here once created by our team.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach($campaigns as $index => $campaign)
                    @php
                        $goal = max($campaign->goal_amount, 1);
                        $progress = min(100, round(($campaign->raised_amount / $goal) * 100, 1));
                    @endphp
                    <div class="col-sm-6 col-lg-4 animate-fade-up" style="animation-delay:{{ 0.1 + ($index * 0.08) }}s;opacity:0">
                        <a href="{{ route('campaigns.show', $campaign->slug) }}" class="card card-hover h-100 text-decoration-none overflow-hidden">
                            <div style="height:4px;background:linear-gradient(90deg,#DB7C1C,#e8943a,#27ae60)"></div>

                            <div class="card-body d-flex flex-column p-4">
                                <div class="d-flex flex-wrap gap-1 mb-3">
                                    @forelse($campaign->categories as $category)
                                        <span class="badge badge-brand rounded-pill">{{ $category->name }}</span>
                                    @empty
                                        <span class="badge bg-light text-secondary rounded-pill">General</span>
                                    @endforelse
                                </div>

                                <h5 class="font-display fw-bold text-dark mb-2" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                    {{ $campaign->title }}
                                </h5>
                                <p class="text-muted small flex-grow-1" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                    {{ $campaign->description ?: 'Support this mission and help us reach the next milestone.' }}
                                </p>

                                <div class="border-top pt-3 mt-3">
                                    <div class="d-flex justify-content-between small mb-2">
                                        <span class="fw-bold text-dark">${{ number_format($campaign->raised_amount / 100, 0) }} <span class="fw-normal text-muted">raised</span></span>
                                        <span class="fw-bold text-primary">{{ $progress }}%</span>
                                    </div>
                                    <div class="progress progress-brand">
                                        <div class="progress-bar" style="width:{{ $progress }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="text-muted" style="font-size:12px">Goal: ${{ number_format($campaign->goal_amount / 100, 0) }}</span>
                                        <span class="fw-semibold text-primary d-inline-flex align-items-center gap-1" style="font-size:12px">
                                            Donate <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            @if($campaigns->hasPages())
                <div class="mt-5">{{ $campaigns->links() }}</div>
            @endif
        @endif
    </section>
</x-layouts.public>
