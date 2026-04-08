<x-public-layout>
    <x-slot:title>{{ $campaign->title }} - DonateHeart</x-slot:title>

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
        <a href="{{ route('campaigns.index') }}" class="inline-flex items-center gap-1 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to campaigns
        </a>
    </div>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Main content --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="h-3 bg-gradient-to-r from-brand-500 to-accent-500"></div>
                    <div class="p-6 md:p-8">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @forelse($campaign->categories as $category)
                                <span class="bg-brand-50 text-brand-700 text-xs font-semibold px-3 py-1 rounded-full">{{ $category->name }}</span>
                            @empty
                                <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">General</span>
                            @endforelse
                        </div>

                        <h1 class="text-2xl md:text-4xl font-display font-bold text-gray-900 leading-tight">{{ $campaign->title }}</h1>
                        <p class="mt-4 text-gray-600 leading-relaxed text-lg">{{ $campaign->description ?: 'Your support helps this campaign move from intention to impact. Every donation counts.' }}</p>

                        @if($campaign->end_date)
                            <div class="mt-6 flex items-center gap-2 text-sm text-gray-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Ends {{ \Carbon\Carbon::parse($campaign->end_date)->format('M d, Y') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar card --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    {{-- Progress --}}
                    <div class="text-center mb-6">
                        <p class="text-3xl font-display font-bold text-gray-900">{{ number_format($campaign->raised_amount / 100, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">raised of {{ number_format($campaign->goal_amount / 100, 2) }} {{ config('donation.currency') }} goal</p>
                    </div>

                    <div class="h-3 bg-gray-100 rounded-full overflow-hidden mb-2">
                        <div class="h-full bg-gradient-to-r from-brand-500 to-accent-500 rounded-full" style="width: {{ $progressPercent }}%"></div>
                    </div>
                    <p class="text-sm font-semibold text-brand-600 text-center mb-6">{{ $progressPercent }}% funded</p>

                    {{-- Stats --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <p class="text-lg font-bold text-gray-900">{{ $campaign->donations_count ?? $campaign->donations()->count() }}</p>
                            <p class="text-xs text-gray-500">Donors</p>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <p class="text-lg font-bold text-gray-900">
                                @if($campaign->end_date && now()->lt($campaign->end_date))
                                    {{ now()->diffInDays($campaign->end_date) }}
                                @else
                                    --
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">Days Left</p>
                        </div>
                    </div>

                    <a href="{{ route('donations.create', ['campaign_slug' => $campaign->slug]) }}" class="btn-primary w-full text-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        Donate Now
                    </a>
                    <a href="{{ route('campaigns.index') }}" class="btn-outline w-full text-center mt-3">Browse Campaigns</a>
                </div>
            </div>
        </div>
    </section>
</x-public-layout>
