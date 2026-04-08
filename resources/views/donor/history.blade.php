<x-donor-layout>
    <x-slot:header>Donation History</x-slot:header>

    {{-- ── Filters ───────────────────────────────────────────── --}}
    <div class="card p-5 mb-6">
        <form method="GET" action="{{ route('dashboard.history') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="form-label !text-xs !text-gray-500">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-input">
            </div>
            <div>
                <label class="form-label !text-xs !text-gray-500">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-input">
            </div>
            <div>
                <label class="form-label !text-xs !text-gray-500">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending"   {{ request('status') === 'pending'   ? 'selected' : '' }}>Pending</option>
                    <option value="refunded"  {{ request('status') === 'refunded'  ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="btn-primary !py-2 !px-5 text-sm flex-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                <a href="{{ route('dashboard.history') }}" class="btn-ghost !py-2 !px-4 text-sm border border-gray-200">Reset</a>
            </div>
        </form>
    </div>

    {{-- ── Table ─────────────────────────────────────────────── --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="th">Date</th>
                        <th class="th">Campaign</th>
                        <th class="th-right">Amount</th>
                        <th class="th-center">Type</th>
                        <th class="th-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($donations as $donation)
                        @php
                            $statusMap = [
                                'completed' => 'badge-green',
                                'pending'   => 'badge-yellow',
                                'failed'    => 'badge-red',
                                'refunded'  => 'badge-gray',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="td text-gray-400 text-xs whitespace-nowrap">{{ $donation->created_at->format('M d, Y') }}</td>
                            <td class="td font-medium text-gray-900">{{ $donation->campaign?->title ?? 'General Donation' }}</td>
                            <td class="td-right font-bold text-gray-900">${{ number_format($donation->amount / 100, 2) }}</td>
                            <td class="td-center">
                                <span class="badge badge-gray capitalize">{{ str_replace('_', ' ', $donation->type) }}</span>
                            </td>
                            <td class="td-center">
                                <span class="badge {{ $statusMap[$donation->status] ?? 'badge-gray' }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="td text-center py-16">
                                <div class="flex flex-col items-center gap-4 text-gray-400">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-500">No donations yet</p>
                                        <a href="{{ route('donations.create') }}"
                                           class="text-brand-600 hover:text-brand-700 font-semibold text-sm mt-1 inline-block">
                                            Make your first donation →
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($donations->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $donations->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-donor-layout>
