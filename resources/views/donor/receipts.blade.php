<x-layouts.donor>
    <x-slot:header>Tax Receipts</x-slot:header>

    <div class="card overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="small text-muted text-uppercase fw-bold" style="font-size:11px">Receipt #</th>
                        <th class="small text-muted text-uppercase fw-bold text-end" style="font-size:11px">Amount</th>
                        <th class="small text-muted text-uppercase fw-bold text-center" style="font-size:11px">Status</th>
                        <th class="small text-muted text-uppercase fw-bold" style="font-size:11px">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($receipts as $receipt)
                        @php $statusMap = ['completed'=>'bg-success-subtle text-success','pending'=>'bg-warning-subtle text-warning','refunded'=>'bg-secondary-subtle text-secondary']; @endphp
                        <tr>
                            <td class="fw-semibold small font-monospace">{{ $receipt->receipt_number }}</td>
                            <td class="text-end fw-bold small">
                                ${{ number_format($receipt->donation->amount / 100, 2) }}
                                <span class="text-muted ms-1" style="font-size:11px">{{ strtoupper($receipt->donation->currency) }}</span>
                            </td>
                            <td class="text-center"><span class="badge rounded-pill {{ $statusMap[$receipt->donation->status] ?? 'bg-light text-secondary' }}">{{ ucfirst($receipt->donation->status) }}</span></td>
                            <td class="text-muted small">{{ $receipt->created_at->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                <svg class="mb-2 mx-auto d-block" width="40" height="40" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                No receipts yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($receipts->hasPages())
            <div class="p-3 border-top">{{ $receipts->links() }}</div>
        @endif
    </div>

    {{-- Yearly bundles --}}
    <h5 class="font-display fw-bold mb-1">Yearly Receipt Bundles</h5>
    <p class="text-muted small mb-3">Download a PDF of all your receipts for a given year — perfect for tax filing.</p>
    <div class="row g-3">
        @for($y = now()->year; $y >= now()->year - 2; $y--)
            <div class="col-sm-4">
                <a href="{{ route('dashboard.receipts.bundle', $y) }}" class="card card-hover text-decoration-none p-4 d-flex flex-row align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:#eef2ff">
                        <svg width="20" height="20" fill="none" stroke="#4f46e5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <div class="font-display fw-bold text-dark">{{ $y }}</div>
                        <div class="text-muted" style="font-size:12px">Download PDF bundle</div>
                    </div>
                </a>
            </div>
        @endfor
    </div>
</x-layouts.donor>
