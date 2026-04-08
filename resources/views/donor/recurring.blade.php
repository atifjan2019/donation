<x-layouts.donor>
    <x-slot:header>Recurring Donations</x-slot:header>

    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="th">Campaign</th>
                        <th class="th-right">Amount</th>
                        <th class="th-center">Frequency</th>
                        <th class="th-center">Status</th>
                        <th class="th-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recurring as $item)
                        @php
                            $statusMap = [
                                'active'    => 'badge-green',
                                'paused'    => 'badge-yellow',
                                'cancelled' => 'badge-red',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="td font-semibold text-gray-900">{{ $item->campaign?->title ?? 'General Donation' }}</td>
                            <td class="td-right font-bold text-gray-900">${{ number_format($item->amount / 100, 2) }}</td>
                            <td class="td-center">
                                <span class="badge badge-gray capitalize">{{ $item->frequency }}</span>
                            </td>
                            <td class="td-center">
                                <span class="badge {{ $statusMap[$item->status] ?? 'badge-gray' }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="td-center">
                                <div class="flex items-center justify-center gap-3">
                                    @if($item->status === 'active')
                                        <form method="POST" action="{{ route('dashboard.recurring.status', $item->id) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="paused">
                                            <button type="submit" class="text-xs font-semibold text-amber-600 hover:text-amber-800 transition-colors">Pause</button>
                                        </form>
                                        <form method="POST" action="{{ route('dashboard.recurring.status', $item->id) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="text-xs font-semibold text-red-500 hover:text-red-700 transition-colors">Cancel</button>
                                        </form>
                                    @elseif($item->status === 'paused')
                                        <form method="POST" action="{{ route('dashboard.recurring.status', $item->id) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit" class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 transition-colors">Resume</button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-300">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="td text-center py-16">
                                <div class="flex flex-col items-center gap-4 text-gray-400">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-500">No recurring donations yet</p>
                                        <a href="{{ route('donations.create') }}"
                                           class="text-brand-600 hover:text-brand-700 font-semibold text-sm mt-1 inline-block">
                                            Set up a recurring donation →
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recurring->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $recurring->links() }}
            </div>
        @endif
    </div>
</x-layouts.donor>
