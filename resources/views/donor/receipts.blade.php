<x-layouts.donor>
    <x-slot:header>Tax Receipts</x-slot:header>

    <div class="card">
        <div class="card-body p-4">
            <h5 class="font-display fw-bold mb-4">Tax Receipts</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead><tr class="border-bottom">
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Receipt #</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Amount</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Date</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Status</th>
                    </tr></thead>
                    <tbody>
                        @forelse($receipts as $receipt)
                            <tr>
                                <td class="fw-semibold">{{ $receipt->receipt_number }}</td>
                                <td class="text-end fw-bold">${{ number_format($receipt->donation->amount / 100, 2) }}</td>
                                <td class="text-muted">{{ $receipt->created_at->format('M d, Y') }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $receipt->donation->status === 'completed' ? 'badge-accent' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                        {{ ucfirst($receipt->donation->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No receipts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($receipts->hasPages())
                <div class="mt-4">{{ $receipts->links() }}</div>
            @endif

            <div class="mt-4 pt-3 border-top">
                <h6 class="font-display fw-bold mb-3">Download Yearly Bundle</h6>
                <div class="d-flex flex-wrap gap-2">
                    @for($y = now()->year; $y >= now()->year - 2; $y--)
                        <a href="{{ route('dashboard.receipts.bundle', $y) }}" class="btn btn-sm btn-outline-primary">{{ $y }} PDF</a>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-layouts.donor>
