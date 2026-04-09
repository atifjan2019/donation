<x-layouts.donor>
    <x-slot:header>Overview</x-slot:header>

    <div class="mb-4">
        <h2 class="font-display fw-bold fs-5">
            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ explode(' ', Auth::user()->name)[0] }} 👋
        </h2>
        <p class="text-muted small mb-0">Here's a summary of your giving activity.</p>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold" style="font-size:11px;letter-spacing:0.08em">Lifetime Donated</div>
                        <div class="font-display fw-bold fs-4 mt-2">${{ number_format($total_donated_lifetime / 100, 2) }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:linear-gradient(135deg,#fef3e2,#fef9f0)">
                        <svg width="20" height="20" fill="#DB7C1C" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold" style="font-size:11px;letter-spacing:0.08em">This Year</div>
                        <div class="font-display fw-bold fs-4 mt-2">${{ number_format($total_donated_this_year / 100, 2) }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:linear-gradient(135deg,#ecfdf5,#f0fdf4)">
                        <svg width="20" height="20" fill="none" stroke="#27ae60" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold" style="font-size:11px;letter-spacing:0.08em">Total Donations</div>
                        <div class="font-display fw-bold fs-4 mt-2">{{ $donation_count }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:linear-gradient(135deg,#fef9f0,#fef3e2)">
                        <svg width="20" height="20" fill="none" stroke="#DB7C1C" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card stat-card p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted text-uppercase fw-bold" style="font-size:11px;letter-spacing:0.08em">Active Recurring</div>
                        <div class="font-display fw-bold fs-4 mt-2">{{ $active_recurring_count }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:linear-gradient(135deg,#f3f4f6,#e5e7eb)">
                        <svg width="20" height="20" fill="none" stroke="#4b5563" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <h6 class="text-muted text-uppercase fw-bold mb-3" style="font-size:12px;letter-spacing:0.1em">Quick Actions</h6>
    <div class="row g-3">
        <div class="col-sm-6 col-lg-4">
            <a href="{{ route('donations.create') }}" class="card text-decoration-none p-4 overflow-hidden position-relative text-white" style="background:linear-gradient(135deg,#DB7C1C,#c46c14);border:none">
                <div class="position-absolute rounded-circle" style="width:120px;height:120px;background:rgba(255,255,255,0.05);top:-30px;right:-30px"></div>
                <svg class="mb-3 position-relative" width="32" height="32" fill="currentColor" viewBox="0 0 24 24" style="z-index:1"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                <h6 class="font-display fw-bold position-relative" style="z-index:1">Make a Donation</h6>
                <p class="mb-0 small position-relative" style="z-index:1;color:rgba(255,255,255,0.7)">Support a cause you care about</p>
            </a>
        </div>
        <div class="col-sm-6 col-lg-4">
            <a href="{{ route('dashboard.history') }}" class="card card-hover text-decoration-none p-4">
                <svg class="mb-3" width="32" height="32" fill="none" stroke="#DB7C1C" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h6 class="font-display fw-bold text-dark">Donation History</h6>
                <p class="mb-0 text-muted small">View all your past donations</p>
            </a>
        </div>
        <div class="col-sm-6 col-lg-4">
            <a href="{{ route('dashboard.receipts') }}" class="card card-hover text-decoration-none p-4">
                <svg class="mb-3" width="32" height="32" fill="none" stroke="#27ae60" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <h6 class="font-display fw-bold text-dark">Tax Receipts</h6>
                <p class="mb-0 text-muted small">Download your donation receipts</p>
            </a>
        </div>
    </div>
</x-layouts.donor>
