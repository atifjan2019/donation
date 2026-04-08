<x-admin-layout>
    <x-slot:header>Donation #{{ $donation->id }}</x-slot:header>

    <div class="max-w-3xl">
        <a href="{{ route('admin.donations.index') }}"
           class="inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-brand-600 transition-colors group mb-6">
            <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to donations
        </a>

        <div class="card overflow-hidden shadow-md">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-brand-600 to-accent-600 p-6 md:p-8">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-white/70 text-xs font-semibold uppercase tracking-wider mb-1">Donation Amount</p>
                        <p class="text-4xl font-display font-bold text-white">${{ number_format($donation->amount / 100, 2) }}</p>
                        <p class="text-white/60 text-sm mt-1">{{ strtoupper($donation->currency) }}</p>
                    </div>
                    @php
                        $statusMap = [
                            'completed' => 'bg-emerald-400/20 text-emerald-100 border border-emerald-400/30',
                            'pending'   => 'bg-amber-400/20 text-amber-100 border border-amber-400/30',
                            'failed'    => 'bg-red-400/20 text-red-100 border border-red-400/30',
                            'refunded'  => 'bg-white/10 text-white/60 border border-white/20',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold uppercase tracking-wide {{ $statusMap[$donation->status] ?? 'bg-white/10 text-white/60' }}">
                        {{ ucfirst($donation->status) }}
                    </span>
                </div>
                @if($donation->transaction_id)
                    <p class="text-white/50 text-xs mt-4 font-mono">TXN: {{ $donation->transaction_id }}</p>
                @endif
            </div>

            <div class="p-6 md:p-8">
                <div class="grid sm:grid-cols-2 gap-6">
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Donor</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $donation->donor_name ?: ($donation->user?->name ?? 'Anonymous') }}</p>
                            <p class="text-sm text-gray-500">{{ $donation->donor_email ?: $donation->user?->email }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Campaign</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $donation->campaign?->title ?? 'General' }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Payment Method</p>
                            <p class="text-sm font-semibold text-gray-900 capitalize">{{ $donation->payment_method }}</p>
                        </div>
                    </div>
                    <div class="space-y-5">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Type</p>
                            <p class="text-sm font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $donation->type) }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Date</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $donation->created_at->format('M d, Y \a\t H:i') }}</p>
                        </div>
                        @if($donation->receipt)
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Receipt #</p>
                                <p class="text-sm font-semibold text-gray-900 font-mono">{{ $donation->receipt->receipt_number }}</p>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1.5">Anonymous</p>
                            <span class="badge {{ $donation->is_anonymous ? 'badge-yellow' : 'badge-gray' }}">
                                {{ $donation->is_anonymous ? 'Yes — Hidden' : 'No — Visible' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($donation->status === 'completed')
                    <div class="mt-8 pt-6 border-t border-gray-100">
                        <p class="text-xs text-gray-400 mb-3 font-medium">Danger Zone</p>
                        <form method="POST" action="{{ route('admin.donations.refund', $donation) }}"
                              onsubmit="return confirm('Are you sure you want to refund this donation? This cannot be undone.')">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn-danger">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                </svg>
                                Mark as Refunded
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
