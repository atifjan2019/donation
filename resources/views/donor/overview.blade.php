<x-donor-layout>
    <x-slot:header>Overview</x-slot:header>

    {{-- ── Greeting ──────────────────────────────────────────── --}}
    <div class="mb-7">
        <h2 class="text-xl font-display font-bold text-gray-900">
            Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 18 ? 'afternoon' : 'evening') }}, {{ explode(' ', Auth::user()->name)[0] }} 👋
        </h2>
        <p class="text-sm text-gray-500 mt-0.5">Here's a summary of your giving activity.</p>
    </div>

    {{-- ── Stats ─────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">
        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Lifetime Donated</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">${{ number_format($total_donated_lifetime / 100, 2) }}</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-brand-100 to-brand-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-brand-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">This Year</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">${{ number_format($total_donated_this_year / 100, 2) }}</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-accent-100 to-accent-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Donations</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">{{ $donation_count }}</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Active Recurring</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">{{ $active_recurring_count }}</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Quick actions ──────────────────────────────────────── --}}
    <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">Quick Actions</h3>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <a href="{{ route('donations.create') }}"
           class="group relative bg-gradient-to-br from-brand-600 via-brand-600 to-brand-700 rounded-2xl p-6 text-white hover:shadow-xl hover:shadow-brand-200/60 hover:-translate-y-0.5 transition-all duration-200 overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <svg class="w-8 h-8 mb-4 opacity-90 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <h3 class="font-display font-bold text-lg relative z-10">Make a Donation</h3>
            <p class="text-sm text-brand-200 mt-1 relative z-10">Support a cause you care about</p>
        </a>

        <a href="{{ route('dashboard.history') }}"
           class="card p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <svg class="w-8 h-8 mb-4 text-accent-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <h3 class="font-display font-bold text-lg text-gray-900">Donation History</h3>
            <p class="text-sm text-gray-500 mt-1">View all your past donations</p>
        </a>

        <a href="{{ route('dashboard.receipts') }}"
           class="card p-6 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <svg class="w-8 h-8 mb-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <h3 class="font-display font-bold text-lg text-gray-900">Tax Receipts</h3>
            <p class="text-sm text-gray-500 mt-1">Download your donation receipts</p>
        </a>
    </div>
</x-donor-layout>
