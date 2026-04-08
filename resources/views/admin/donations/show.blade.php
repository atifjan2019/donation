<x-layouts.admin>
    <x-slot:header>Donation #{{ $donation->id }}</x-slot:header>

    <div style="max-width:720px">
        <a href="{{ route('admin.donations.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-4">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to donations
        </a>

        <div class="card overflow-hidden shadow">
            {{-- Header --}}
            <div class="p-4 p-md-5" style="background:linear-gradient(135deg,#4f46e5,#818cf8,#fbbf24)">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-uppercase fw-bold" style="font-size:11px;color:rgba(255,255,255,0.6);letter-spacing:0.1em">Donation Amount</div>
                        <div class="font-display fw-bold text-white display-6">${{ number_format($donation->amount / 100, 2) }}</div>
                        <div style="color:rgba(255,255,255,0.5);font-size:13px" class="mt-1">{{ strtoupper($donation->currency) }}</div>
                    </div>
                    @php
                        $statusMap = ['completed'=>'background:rgba(16,185,129,0.2);color:#a7f3d0;border:1px solid rgba(16,185,129,0.3)','pending'=>'background:rgba(245,158,11,0.2);color:#fde68a;border:1px solid rgba(245,158,11,0.3)','failed'=>'background:rgba(239,68,68,0.2);color:#fca5a5;border:1px solid rgba(239,68,68,0.3)','refunded'=>'background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.6);border:1px solid rgba(255,255,255,0.2)'];
                    @endphp
                    <span class="badge rounded-pill px-3 py-2 fw-bold text-uppercase" style="{{ $statusMap[$donation->status] ?? '' }};font-size:11px;letter-spacing:0.05em">{{ ucfirst($donation->status) }}</span>
                </div>
                @if($donation->transaction_id)
                    <div class="font-monospace mt-3" style="font-size:12px;color:rgba(255,255,255,0.4)">TXN: {{ $donation->transaction_id }}</div>
                @endif
            </div>

            <div class="card-body p-4 p-md-5">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Donor</div>
                            <div class="fw-semibold small">{{ $donation->donor_name ?: ($donation->user?->name ?? 'Anonymous') }}</div>
                            <div class="text-muted small">{{ $donation->donor_email ?: $donation->user?->email }}</div>
                        </div>
                        <div class="mb-4">
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Campaign</div>
                            <div class="fw-semibold small">{{ $donation->campaign?->title ?? 'General' }}</div>
                        </div>
                        <div>
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Payment Method</div>
                            <div class="fw-semibold small text-capitalize">{{ $donation->payment_method }}</div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Type</div>
                            <div class="fw-semibold small text-capitalize">{{ str_replace('_', ' ', $donation->type) }}</div>
                        </div>
                        <div class="mb-4">
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Date</div>
                            <div class="fw-semibold small">{{ $donation->created_at->format('M d, Y \a\t H:i') }}</div>
                        </div>
                        @if($donation->receipt)
                        <div class="mb-4">
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Receipt #</div>
                            <div class="fw-semibold small font-monospace">{{ $donation->receipt->receipt_number }}</div>
                        </div>
                        @endif
                        <div>
                            <div class="text-uppercase fw-bold text-muted mb-1" style="font-size:11px;letter-spacing:0.1em">Anonymous</div>
                            <span class="badge rounded-pill {{ $donation->is_anonymous ? 'bg-warning-subtle text-warning' : 'bg-light text-secondary' }}">
                                {{ $donation->is_anonymous ? 'Yes — Hidden' : 'No — Visible' }}
                            </span>
                        </div>
                    </div>
                </div>

                @if($donation->status === 'completed')
                    <div class="border-top mt-4 pt-4">
                        <div class="text-muted small mb-2">Danger Zone</div>
                        <form method="POST" action="{{ route('admin.donations.refund', $donation) }}" onsubmit="return confirm('Are you sure you want to refund this donation? This cannot be undone.')">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
                                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                Mark as Refunded
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
