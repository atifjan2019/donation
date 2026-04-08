<x-admin-layout>
    <x-slot:header>Dashboard</x-slot:header>

    {{-- ── Stat cards ───────────────────────────────────────── --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-8">

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Raised</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">${{ number_format($totals['all_time'] / 100, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-2 font-medium">All time</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-brand-100 to-brand-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">This Month</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">${{ number_format($totals['this_month'] / 100, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-2 font-medium">Current month</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-accent-100 to-accent-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Total Donations</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">{{ number_format($donation_count) }}</p>
                    <p class="text-xs text-gray-400 mt-2 font-medium">All time count</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Avg. Donation</p>
                    <p class="text-2xl font-display font-bold text-gray-900 mt-2">${{ number_format($average_donation / 100, 2) }}</p>
                    <p class="text-xs text-gray-400 mt-2 font-medium">Per donation</p>
                </div>
                <div class="w-11 h-11 bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Main grid ─────────────────────────────────────────── --}}
    <div class="grid lg:grid-cols-3 gap-6 mb-6">

        {{-- Top Campaigns --}}
        <div class="lg:col-span-2 card p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-display font-semibold text-gray-900">Top Campaigns</h3>
                <a href="{{ route('admin.campaigns.index') }}" class="text-xs font-semibold text-brand-600 hover:text-brand-700 transition-colors">
                    View all →
                </a>
            </div>
            <div class="overflow-x-auto -mx-1">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="th !px-1 !py-2.5">Campaign</th>
                            <th class="th-right !px-1 !py-2.5">Raised</th>
                            <th class="th-right !px-1 !py-2.5 hidden sm:table-cell">Goal</th>
                            <th class="th-right !px-1 !py-2.5">Progress</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($top_campaigns as $tc)
                            @php
                                $cGoal = max($tc->goal_amount, 1);
                                $cProg = min(100, round(($tc->completed_donations_sum ?? 0) / $cGoal * 100));
                            @endphp
                            <tr class="hover:bg-gray-50/60 transition-colors">
                                <td class="td !px-1 font-medium text-gray-900">{{ Str::limit($tc->title, 28) }}</td>
                                <td class="td-right !px-1 font-semibold text-gray-900">${{ number_format(($tc->completed_donations_sum ?? 0) / 100, 0) }}</td>
                                <td class="td-right !px-1 text-gray-400 hidden sm:table-cell">${{ number_format($tc->goal_amount / 100, 0) }}</td>
                                <td class="td-right !px-1">
                                    <div class="flex items-center justify-end gap-2">
                                        <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden hidden sm:block">
                                            <div class="h-full bg-gradient-to-r from-brand-500 to-accent-500 rounded-full" style="width: {{ $cProg }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold text-gray-600 w-9 text-right">{{ $cProg }}%</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="td !px-1 text-center text-gray-400 py-8">No campaigns yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Donation split + today --}}
        <div class="card p-6">
            <h3 class="font-display font-semibold text-gray-900 mb-5">Donation Split</h3>
            <div class="space-y-3">
                @forelse($recurring_vs_one_time as $item)
                    <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3.5">
                        <div>
                            <p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $item->type) }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $item->count }} {{ Str::plural('donation', $item->count) }}</p>
                        </div>
                        <p class="font-display font-bold text-gray-900 text-sm">${{ number_format($item->total / 100, 0) }}</p>
                    </div>
                @empty
                    <p class="text-sm text-gray-400 text-center py-8">No data available</p>
                @endforelse
            </div>

            <div class="mt-5 pt-4 border-t border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 font-medium">Today's Total</p>
                        <p class="text-xl font-display font-bold text-gray-900 mt-0.5">${{ number_format($totals['today'] / 100, 2) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Quick actions ──────────────────────────────────────── --}}
    <div class="grid sm:grid-cols-3 gap-4">
        <a href="{{ route('admin.donations.index') }}"
           class="card p-5 hover:shadow-md transition-all duration-200 group hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-brand-50 rounded-xl flex items-center justify-center group-hover:bg-brand-100 transition-colors">
                    <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">All Donations</p>
                    <p class="text-xs text-gray-400 mt-0.5">Manage and export</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.campaigns.index') }}"
           class="card p-5 hover:shadow-md transition-all duration-200 group hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-accent-50 rounded-xl flex items-center justify-center group-hover:bg-accent-100 transition-colors">
                    <svg class="w-5 h-5 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Manage Campaigns</p>
                    <p class="text-xs text-gray-400 mt-0.5">Create or edit</p>
                </div>
            </div>
        </a>

        <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['export' => 'csv'])) }}"
           class="card p-5 hover:shadow-md transition-all duration-200 group hover:-translate-y-0.5">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-amber-50 rounded-xl flex items-center justify-center group-hover:bg-amber-100 transition-colors">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Export CSV</p>
                    <p class="text-xs text-gray-400 mt-0.5">Download all donations</p>
                </div>
            </div>
        </a>
    </div>
</x-admin-layout>
