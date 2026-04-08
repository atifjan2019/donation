<x-admin-layout>
    <x-slot:header>Donations</x-slot:header>

    {{-- ── Filters ───────────────────────────────────────────── --}}
    <div class="card p-5 mb-6">
        <form method="GET" action="{{ route('admin.donations.index') }}"
              class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="form-label !text-xs !text-gray-500">From Date</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-input">
            </div>
            <div>
                <label class="form-label !text-xs !text-gray-500">To Date</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-input">
            </div>
            <div>
                <label class="form-label !text-xs !text-gray-500">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="completed"  {{ request('status') === 'completed'  ? 'selected' : '' }}>Completed</option>
                    <option value="pending"    {{ request('status') === 'pending'    ? 'selected' : '' }}>Pending</option>
                    <option value="failed"     {{ request('status') === 'failed'     ? 'selected' : '' }}>Failed</option>
                    <option value="refunded"   {{ request('status') === 'refunded'   ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div>
                <label class="form-label !text-xs !text-gray-500">Donor</label>
                <input type="text" name="donor" value="{{ request('donor') }}"
                       placeholder="Search name or email" class="form-input">
            </div>
            <div class="sm:col-span-2 lg:col-span-4 flex flex-wrap gap-3">
                <button type="submit" class="btn-primary !py-2 !px-5 text-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Filter
                </button>
                <a href="{{ route('admin.donations.index') }}" class="btn-ghost !py-2 !px-5 text-sm border border-gray-200">
                    Reset
                </a>
                <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['export' => 'csv'])) }}"
                   class="btn-secondary !py-2 !px-5 text-sm ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </a>
            </div>
        </form>
    </div>

    {{-- ── Table ─────────────────────────────────────────────── --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="th">#ID</th>
                        <th class="th">Donor</th>
                        <th class="th">Campaign</th>
                        <th class="th-right">Amount</th>
                        <th class="th-center">Status</th>
                        <th class="th">Date</th>
                        <th class="th-center">Actions</th>
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
                            <td class="td font-mono text-xs text-gray-400">#{{ $donation->id }}</td>
                            <td class="td">
                                <p class="font-semibold text-gray-900 text-xs">{{ $donation->donor_name ?: ($donation->user?->name ?? 'Anonymous') }}</p>
                                <p class="text-gray-400 text-xs mt-0.5">{{ $donation->donor_email ?: $donation->user?->email }}</p>
                            </td>
                            <td class="td text-gray-500 max-w-[140px] truncate">
                                {{ $donation->campaign?->title ?? '—' }}
                            </td>
                            <td class="td-right font-bold text-gray-900">${{ number_format($donation->amount / 100, 2) }}</td>
                            <td class="td-center">
                                <span class="badge {{ $statusMap[$donation->status] ?? 'badge-gray' }}">
                                    {{ ucfirst($donation->status) }}
                                </span>
                            </td>
                            <td class="td text-gray-400 text-xs whitespace-nowrap">{{ $donation->created_at->format('M d, Y') }}</td>
                            <td class="td-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.donations.show', $donation) }}"
                                       class="text-brand-600 hover:text-brand-800 font-semibold text-xs transition-colors">
                                        View
                                    </a>
                                    @if($donation->status === 'completed')
                                        <form method="POST" action="{{ route('admin.donations.refund', $donation) }}"
                                              class="inline" onsubmit="return confirm('Refund this donation?')">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-semibold text-xs transition-colors">
                                                Refund
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="td text-center py-16">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    No donations found
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
</x-admin-layout>
