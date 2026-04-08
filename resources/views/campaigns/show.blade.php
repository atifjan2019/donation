<x-public-layout>
    <x-slot:title>{{ $campaign->title }} — DonateHeart</x-slot:title>

    {{-- ── Breadcrumb ───────────────────────────────────────── --}}
    <div class="page-section pt-8 pb-0">
        <a href="{{ route('campaigns.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors group">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            All Campaigns
        </a>
    </div>

    <section class="page-section py-8">
        <div class="grid lg:grid-cols-3 gap-8">

            {{-- ── Main content ─────────────────────────────── --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="card overflow-hidden">
                    <div class="h-2 bg-gradient-to-r from-brand-500 to-accent-500"></div>
                    <div class="p-6 md:p-8">
                        {{-- Categories --}}
                        <div class="flex flex-wrap gap-2 mb-5">
                            @forelse($campaign->categories as $category)
                                <span class="badge badge-brand text-xs">{{ $category->name }}</span>
                            @empty
                                <span class="badge badge-gray text-xs">General</span>
                            @endforelse
                        </div>

                        <h1 class="text-2xl md:text-3xl font-display font-bold text-gray-900 leading-tight mb-4">
                            {{ $campaign->title }}
                        </h1>

                        <p class="text-gray-600 leading-relaxed text-base">
                            {{ $campaign->description ?: 'Your support helps this campaign move from intention to impact. Every donation counts toward making this vision a reality.' }}
                        </p>

                        @if($campaign->end_date)
                            <div class="mt-6 inline-flex items-center gap-2 bg-amber-50 border border-amber-200 text-amber-700 px-4 py-2.5 rounded-xl text-sm font-medium">
                                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Campaign ends {{ \Carbon\Carbon::parse($campaign->end_date)->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Impact section --}}
                <div class="card p-6 md:p-8">
                    <h3 class="font-display font-semibold text-gray-900 mb-4 text-lg">Why Your Support Matters</h3>
                    <div class="grid sm:grid-cols-3 gap-4">
                        @foreach([['100%', 'Transparent Tracking', 'See exactly how funds are used'], ['Fast', 'Instant Processing', 'Donations processed immediately'], ['Safe', 'Secure Payments', 'Protected by Stripe & PayPal']] as $item)
                            <div class="bg-gray-50 rounded-xl p-4 text-center">
                                <p class="text-xl font-display font-bold text-brand-600 mb-1">{{ $item[0] }}</p>
                                <p class="text-sm font-semibold text-gray-900">{{ $item[1] }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $item[2] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── Sidebar ───────────────────────────────────── --}}
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    {{-- Raised amount --}}
                    <div class="mb-5">
                        <p class="text-3xl font-display font-bold text-gray-900">
                            ${{ number_format($campaign->raised_amount / 100, 0) }}
                        </p>
                        <p class="text-sm text-gray-500 mt-0.5">
                            raised of <span class="font-semibold text-gray-700">${{ number_format($campaign->goal_amount / 100, 0) }}</span> goal
                        </p>
                    </div>

                    {{-- Progress bar --}}
                    <div class="progress-track mb-1.5">
                        <div class="progress-fill" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <p class="text-sm font-bold text-brand-600 mb-6">{{ $progressPercent }}% funded</p>

                    {{-- Stats --}}
                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
                            <p class="text-2xl font-display font-bold text-gray-900">
                                {{ $campaign->donations_count ?? $campaign->donations()->count() }}
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5 font-medium">Donors</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3.5 text-center">
                            <p class="text-2xl font-display font-bold text-gray-900">
                                @if($campaign->end_date && now()->lt($campaign->end_date))
                                    {{ now()->diffInDays($campaign->end_date) }}
                                @else
                                    <span class="text-lg">∞</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500 mt-0.5 font-medium">Days Left</p>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <a href="{{ route('donations.create', ['campaign_slug' => $campaign->slug]) }}"
                       class="btn-primary w-full text-center text-base !py-3.5 mb-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        Donate Now
                    </a>
                    <a href="{{ route('campaigns.index') }}" class="btn-outline w-full text-center text-sm !py-2.5">
                        Browse All Campaigns
                    </a>

                    {{-- Trust badge --}}
                    <div class="mt-5 pt-4 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-400">
                        <svg class="w-3.5 h-3.5 text-emerald-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                        Secure payment · Money-back guarantee
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
