<x-layouts.donor>
    <x-slot:header>Donation History</x-slot:header>

    {{-- Filters --}}
    <div class="card p-4 mb-4">
        <form method="GET" action="{{ route('dashboard.history') }}" class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small text-muted fw-semibold">From</label>
                <input type="date" name="from" value="{{ request('from') }}" class="form-control">
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small text-muted fw-semibold">To</label>
                <input type="date" name="to" value="{{ request('to') }}" class="form-control">
            </div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small text-muted fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="refunded" {{ request('status') === 'refunded' ? 'selected' : '' }}>Refunded</option>
                </select>
            </div>
            <div class="col-sm-6 col-lg-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-gradient btn-sm flex-grow-1">Filter</button>
                <a href="{{ route('dashboard.history') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="small text-muted text-uppercase fw-bold" style="font-size:11px">Date</th>
                        <th class="small text-muted text-uppercase fw-bold" style="font-size:11px">Campaign</th>
                        <th class="small text-muted text-uppercase fw-bold text-end" style="font-size:11px">Amount</th>
                        <th class="small text-muted text-uppercase fw-bold text-center" style="font-size:11px">Type</th>
                        <th class="small text-muted text-uppercase fw-bold text-center" style="font-size:11px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        @php
                            $statusMap = ['completed'=>'bg-success-subtle text-success','pending'=>'bg-warning-subtle text-warning','failed'=>'bg-danger-subtle text-danger','refunded'=>'bg-secondary-subtle text-secondary'];
                        @endphp
                        <tr>
                            <td class="text-muted small">{{ $donation->created_at->format('M d, Y') }}</td>
                            <td class="fw-semibold small">{{ $donation->campaign?->title ?? 'General Donation' }}</td>
                            <td class="text-end fw-bold small">${{ number_format($donation->amount / 100, 2) }}</td>
                            <td class="text-center"><span class="badge bg-light text-secondary rounded-pill text-capitalize">{{ str_replace('_', ' ', $donation->type) }}</span></td>
                            <td class="text-center"><span class="badge rounded-pill {{ $statusMap[$donation->status] ?? 'bg-light text-secondary' }}">{{ ucfirst($donation->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <svg class="mb-2" width="40" height="40" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="text-muted fw-medium mb-1">No donations yet</p>
                                <a href="{{ route('donations.create') }}" class="text-primary fw-semibold small">Make your first donation →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($donations->hasPages())
            <div class="p-3 border-top">{{ $donations->withQueryString()->links() }}</div>
        @endif
    </div>
</x-layouts.donor>
