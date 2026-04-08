<x-layouts.donor>
    <x-slot:header>Tax Receipts</x-slot:header>

    {{-- ── Receipts table ────────────────────────────────────── --}}
    <div class="card overflow-hidden mb-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="th">Receipt #</th>
                        <th class="th-right">Amount</th>
                        <th class="th-center">Status</th>
                        <th class="th">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($receipts as $receipt)
                        @php
                            $statusMap = [
                                'completed' => 'badge-green',
                                'pending'   => 'badge-yellow',
                                'refunded'  => 'badge-gray',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="td font-mono text-xs font-semibold text-gray-900">{{ $receipt->receipt_number }}</td>
                            <td class="td-right font-bold text-gray-900">
                                ${{ number_format($receipt->donation->amount / 100, 2) }}
                                <span class="text-xs text-gray-400 ml-1">{{ strtoupper($receipt->donation->currency) }}</span>
                            </td>
                            <td class="td-center">
                                <span class="badge {{ $statusMap[$receipt->donation->status] ?? 'badge-gray' }}">
                                    {{ ucfirst($receipt->donation->status) }}
                                </span>
                            </td>
                            <td class="td text-gray-400 text-xs">{{ $receipt->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="td text-center py-16 text-gray-400">
                                <svg class="w-10 h-10 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                No receipts yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($receipts->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $receipts->links() }}
            </div>
        @endif
    </div>

    {{-- ── Yearly bundles ────────────────────────────────────── --}}
    <div>
        <h3 class="font-display font-semibold text-gray-900 mb-1">Yearly Receipt Bundles</h3>
        <p class="text-sm text-gray-500 mb-5">Download a PDF of all your receipts for a given year — perfect for tax filing.</p>
        <div class="grid sm:grid-cols-3 gap-4">
            @for($y = now()->year; $y >= now()->year - 2; $y--)
                <a href="{{ route('dashboard.receipts.bundle', $y) }}"
                   class="card p-5 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-4">
                    <div class="w-11 h-11 bg-brand-50 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="font-display font-bold text-gray-900">{{ $y }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">Download PDF bundle</p>
                    </div>
                </a>
            @endfor
        </div>
    </div>
</x-layouts.donor>
