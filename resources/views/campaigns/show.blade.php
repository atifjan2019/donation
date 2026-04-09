<x-layouts.public>
    <x-slot:title>{{ $campaign->title }} — DonateHeart</x-slot:title>

    <div class="container py-4">
        <a href="{{ route('campaigns.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            All Campaigns
        </a>

        <div class="row g-4">
            <div class="col-lg-8 animate-fade-up">
                <div class="card overflow-hidden">
                    <div style="height:5px;background:linear-gradient(90deg,#DB7C1C,#e8943a,#27ae60)"></div>
                    <div class="card-body p-4 p-md-5">
                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @forelse($campaign->categories as $category)
                                <span class="badge badge-brand rounded-pill">{{ $category->name }}</span>
                            @empty
                                <span class="badge bg-light text-secondary rounded-pill">General</span>
                            @endforelse
                        </div>
                        <h1 class="font-display fw-bold mb-3">{{ $campaign->title }}</h1>
                        <p class="text-muted">{{ $campaign->description ?: 'Your support helps this campaign move from intention to impact. Every donation counts toward making this vision a reality.' }}</p>
                        @if($campaign->end_date)
                            <div class="alert alert-warning d-inline-flex align-items-center gap-2 rounded-4 border-0 mt-3 py-2 px-3 small fw-medium" style="background:#fef3e2">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Campaign ends {{ \Carbon\Carbon::parse($campaign->end_date)->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card mt-4 animate-fade-up" style="animation-delay:0.15s;opacity:0">
                    <div class="card-body p-4 p-md-5">
                        <h5 class="font-display fw-bold mb-4">Why Your Support Matters</h5>
                        <div class="row g-3">
                            @foreach([['100%','Transparent Tracking','See exactly how funds are used'],['Fast','Instant Processing','Donations processed immediately'],['Safe','Secure Payments','Protected by Stripe & PayPal']] as $item)
                                <div class="col-sm-4">
                                    <div class="rounded-4 p-4 text-center" style="background:linear-gradient(135deg,#f9fafb,#f3f4f6);border:1px solid rgba(0,0,0,0.04)">
                                        <div class="font-display fw-bold fs-4 text-gradient mb-1">{{ $item[0] }}</div>
                                        <div class="fw-semibold small text-dark">{{ $item[1] }}</div>
                                        <div class="text-muted" style="font-size:12px">{{ $item[2] }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 animate-fade-up" style="animation-delay:0.2s;opacity:0">
                <div class="card sticky-top" style="top:80px">
                    <div class="card-body p-4">
                        <h2 class="font-display fw-bold mb-1">${{ number_format($campaign->raised_amount / 100, 0) }}</h2>
                        <p class="text-muted small">raised of <span class="fw-semibold text-dark">${{ number_format($campaign->goal_amount / 100, 0) }}</span> goal</p>

                        <div class="progress progress-brand mb-1">
                            <div class="progress-bar" style="width:{{ $progressPercent }}%"></div>
                        </div>
                        <p class="fw-bold text-primary small mb-4">{{ $progressPercent }}% funded</p>

                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <div class="rounded-4 p-3 text-center" style="background:linear-gradient(135deg,#fef3e2,#fff)">
                                    <div class="font-display fw-bold fs-4">{{ $campaign->donations_count ?? $campaign->donations()->count() }}</div>
                                    <div class="text-muted" style="font-size:12px">Donors</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="rounded-4 p-3 text-center" style="background:linear-gradient(135deg,#ecfdf5,#fff)">
                                    <div class="font-display fw-bold fs-4">
                                        @if($campaign->end_date && now()->lt($campaign->end_date)) {{ now()->diffInDays($campaign->end_date) }} @else ∞ @endif
                                    </div>
                                    <div class="text-muted" style="font-size:12px">Days Left</div>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('donations.create', ['campaign_slug' => $campaign->slug]) }}" class="btn btn-gradient w-100 py-3 d-flex align-items-center justify-content-center gap-2 mb-2">
                            <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            Donate Now
                        </a>
                        <a href="{{ route('campaigns.index') }}" class="btn btn-outline-primary w-100 py-2">Browse All Campaigns</a>

                        <div class="border-top mt-3 pt-3 d-flex align-items-center gap-2 text-muted" style="font-size:12px">
                            <svg width="14" height="14" fill="none" stroke="#27ae60" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            Secure payment · Money-back guarantee
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.public>
