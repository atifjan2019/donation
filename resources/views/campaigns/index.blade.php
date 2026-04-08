<x-layouts.public>
    <x-slot:title>Campaigns — DonateHeart</x-slot:title>

    {{-- ── Hero ─────────────────────────────────────────────── --}}
    <section class="page-hero">
        {{-- Background decoration --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-20 -right-20 w-96 h-96 bg-white/5 rounded-full"></div>
            <div class="absolute -bottom-10 -left-10 w-72 h-72 bg-black/10 rounded-full"></div>
        </div>

        <div class="relative page-section py-16 md:py-24">
            <div class="flex flex-wrap items-center gap-3 mb-5">
                <span class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur text-white text-xs font-semibold uppercase tracking-wider px-4 py-1.5 rounded-full">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    Donation Portal
                </span>
            </div>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white leading-tight max-w-3xl">
                Fund causes that matter,<br class="hidden md:block"/>
                <span class="text-brand-200">track every milestone.</span>
            </h1>
            <p class="mt-4 text-brand-100 text-lg max-w-xl leading-relaxed">
                Choose a campaign, donate in minutes, and see your impact grow over time.
            </p>
        </div>
    </section>

    {{-- ── Campaigns grid ───────────────────────────────────── --}}
    <section class="page-section py-14">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h2 class="text-2xl font-display font-bold text-gray-900">Active Campaigns</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $campaigns->total() }} {{ Str::plural('campaign', $campaigns->total()) }} available</p>
            </div>
            <a href="{{ route('donations.create') }}" class="btn-primary !py-2.5 !px-5 text-sm hidden sm:inline-flex">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                Donate Now
            </a>
        </div>

        @if($campaigns->count() === 0)
            <div class="card border-2 border-dashed border-gray-200 p-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <h3 class="text-xl font-display font-semibold text-gray-900">No campaigns yet</h3>
                <p class="mt-2 text-gray-500 max-w-sm mx-auto">New campaigns will appear here once created by our team.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($campaigns as $campaign)
                    @php
                        $goal = max($campaign->goal_amount, 1);
                        $progress = min(100, round(($campaign->raised_amount / $goal) * 100, 1));
                    @endphp
                    <a href="{{ route('campaigns.show', $campaign->slug) }}"
                       class="group card hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden flex flex-col">
                        {{-- Top color accent --}}
                        <div class="h-1.5 bg-gradient-to-r from-brand-500 to-accent-500 shrink-0"></div>

                        <div class="p-6 flex flex-col flex-1">
                            {{-- Categories --}}
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @forelse($campaign->categories as $category)
                                    <span class="badge badge-brand">{{ $category->name }}</span>
                                @empty
                                    <span class="badge badge-gray">General</span>
                                @endforelse
                            </div>

                            {{-- Title & description --}}
                            <h3 class="text-lg font-display font-bold text-gray-900 group-hover:text-brand-600 transition-colors line-clamp-2 mb-2">
                                {{ $campaign->title }}
                            </h3>
                            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed flex-1">
                                {{ $campaign->description ?: 'Support this mission and help us reach the next milestone.' }}
                            </p>

                            {{-- Progress --}}
                            <div class="mt-5 pt-5 border-t border-gray-50">
                                <div class="flex justify-between items-baseline text-sm mb-2">
                                    <span class="font-bold text-gray-900">${{ number_format($campaign->raised_amount / 100, 0) }} <span class="text-xs font-normal text-gray-400">raised</span></span>
                                    <span class="text-xs font-semibold text-brand-600">{{ $progress }}%</span>
                                </div>
                                <div class="progress-track">
                                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="flex justify-between items-center mt-3">
                                    <span class="text-xs text-gray-400">Goal: ${{ number_format($campaign->goal_amount / 100, 0) }}</span>
                                    <span class="text-xs font-semibold text-brand-600 group-hover:translate-x-0.5 transition-transform inline-flex items-center gap-1">
                                        Donate
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($campaigns->hasPages())
                <div class="mt-12">
                    {{ $campaigns->links() }}
                </div>
            @endif
        @endif
    </section>
</x-layouts.public>
