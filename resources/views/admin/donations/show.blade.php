<x-layouts.admin>
    <x-slot:header>Donation #{{ $donation->id }}</x-slot:header>

    <a href="{{ route('admin.donations.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1 mb-4">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to donations
    </a>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4">
                <h5 class="font-display fw-bold mb-4">Donation Details</h5>
                <div class="row g-3">
                    @foreach([
                        ['Donor Name', $donation->donor_name ?? 'N/A'],
                        ['Donor Email', $donation->donor_email ?? 'N/A'],
                        ['Amount', '$'.number_format($donation->amount / 100, 2).' '.$donation->currency],
                        ['Payment Method', ucfirst($donation->payment_method ?? 'N/A')],
                        ['Type', ucfirst(str_replace('_', ' ', $donation->type))],
                        ['Status', ucfirst($donation->status)],
                        ['Transaction ID', $donation->transaction_id ?? 'N/A'],
                        ['Date', $donation->created_at->format('M d, Y H:i')],
                        ['Campaign', $donation->campaign?->title ?? 'General'],
                        ['Anonymous', $donation->is_anonymous ? 'Yes' : 'No'],
                    ] as $field)
                        <div class="col-sm-6">
                            <div class="text-muted text-uppercase fw-bold" style="font-size:11px;letter-spacing:0.05em">{{ $field[0] }}</div>
                            <div class="fw-semibold mt-1">{{ $field[1] }}</div>
                        </div>
                    @endforeach
                </div>

                @if($donation->message)
                    <div class="mt-4 pt-3 border-top">
                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size:11px">Message</div>
                        <p class="mb-0">{{ $donation->message }}</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4">
                <h6 class="font-display fw-bold mb-3">Actions</h6>
                @if($donation->status === 'completed')
                    <form method="POST" action="{{ route('admin.donations.refund', $donation) }}" onsubmit="return confirm('Mark this donation as refunded?')">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn btn-outline-danger w-100">Mark as Refunded</button>
                    </form>
                @else
                    <p class="text-muted small">No actions available for {{ $donation->status }} donations.</p>
                @endif

                @if($donation->receipt)
                    <div class="mt-3 pt-3 border-top">
                        <div class="text-muted text-uppercase fw-bold mb-1" style="font-size:11px">Receipt</div>
                        <div class="fw-semibold small">{{ $donation->receipt->receipt_number }}</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.admin>
