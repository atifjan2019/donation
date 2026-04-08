<x-public-layout>
    <x-slot:title>Campaigns - DonateHeart</x-slot:title>

    {{-- Hero --}}
    <section class="bg-gradient-to-br from-brand-600 via-brand-700 to-accent-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" viewBox="0 0 800 400" fill="none"><circle cx="700" cy="50" r="200" fill="white"/><circle cx="100" cy="350" r="150" fill="white"/></svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
            <span class="inline-block bg-white/20 backdrop-blur text-white text-xs font-semibold uppercase tracking-wider px-4 py-1.5 rounded-full mb-4">Donation Portal</span>
            <h1 class="text-3xl md:text-5xl font-display font-bold text-white leading-tight max-w-3xl">Fund causes that matter,<br class="hidden md:block"/> with transparent progress.</h1>
            <p class="mt-4 text-brand-100 text-lg max-w-2xl">Choose a campaign, donate in minutes, and track your impact over time.</p>
        </div>
    </section>

    {{-- Campaigns grid --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-display font-bold text-gray-900">Active Campaigns</h2>
            <span class="bg-brand-50 text-brand-700 text-sm font-semibold px-3 py-1 rounded-full">{{ $campaigns->total() }} total</span>
        </div>

        @if($campaigns->count() === 0)
            <div class="bg-white rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <h3 class="text-xl font-display font-semibold text-gray-900">No campaigns yet</h3>
                <p class="mt-2 text-gray-500">New campaigns will appear here once created.</p>
            </div>
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($campaigns as $campaign)
                    @php
                        $goal = max($campaign->goal_amount, 1);
                        $progress = min(100, round(($campaign->raised_amount / $goal) * 100, 2));
                    @endphp
                    <a href="{{ route('campaigns.show', $campaign->slug) }}" class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                        <div class="h-2 bg-gradient-to-r from-brand-500 to-accent-500"></div>
                        <div class="p-6">
                            <div class="flex flex-wrap gap-2 mb-3">
                                @forelse($campaign->categories as $category)
                                    <span class="bg-brand-50 text-brand-700 text-xs font-semibold px-2.5 py-1 rounded-full">{{ $category->name }}</span>
                                @empty
                                    <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2.5 py-1 rounded-full">General</span>
                                @endforelse
                            </div>

                            <h3 class="text-lg font-display font-bold text-gray-900 group-hover:text-brand-600 transition-colors line-clamp-2">{{ $campaign->title }}</h3>
                            <p class="mt-2 text-sm text-gray-500 line-clamp-2">{{ $campaign->description ?: 'Support this mission and help us reach the next milestone.' }}</p>

                            <div class="mt-5">
                                <div class="flex justify-between text-sm font-medium text-gray-600 mb-2">
                                    <span>{{ $progress }}% funded</span>
                                    <span>{{ number_format($campaign->goal_amount / 100, 2) }} {{ config('donation.currency') }}</span>
                                </div>
                                <div class="h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-brand-500 to-accent-500 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                                </div>
                                <div class="mt-3 flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-900">{{ number_format($campaign->raised_amount / 100, 2) }} raised</span>
                                    <span class="text-xs font-medium text-brand-600 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                        Donate <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $campaigns->links() }}
            </div>
        @endif
    </section>
</x-public-layout>
