<x-layouts.admin>
    <x-slot:header>Donations</x-slot:header>

    {{-- Filters --}}
    <div class="card p-4 mb-4">
        <form method="GET" action="{{ route('admin.donations.index') }}" class="row g-3">
            <div class="col-sm-6 col-lg-3"><label class="form-label small text-muted fw-semibold">From</label><input type="date" name="from" value="{{ request('from') }}" class="form-control"></div>
            <div class="col-sm-6 col-lg-3"><label class="form-label small text-muted fw-semibold">To</label><input type="date" name="to" value="{{ request('to') }}" class="form-control"></div>
            <div class="col-sm-6 col-lg-3">
                <label class="form-label small text-muted fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    @foreach(['completed','pending','failed','refunded'] as $s) <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option> @endforeach
                </select>
            </div>
            <div class="col-sm-6 col-lg-3"><label class="form-label small text-muted fw-semibold">Donor</label><input type="text" name="donor" value="{{ request('donor') }}" placeholder="Search name or email" class="form-control"></div>
            <div class="col-12 d-flex flex-wrap gap-2">
                <button type="submit" class="btn btn-gradient btn-sm">Filter</button>
                <a href="{{ route('admin.donations.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['export' => 'csv'])) }}" class="btn btn-gradient-accent btn-sm ms-auto">Export CSV</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted text-uppercase fw-bold" style="font-size:11px">#ID</th>
                        <th class="text-muted text-uppercase fw-bold" style="font-size:11px">Donor</th>
                        <th class="text-muted text-uppercase fw-bold" style="font-size:11px">Campaign</th>
                        <th class="text-muted text-uppercase fw-bold text-end" style="font-size:11px">Amount</th>
                        <th class="text-muted text-uppercase fw-bold text-center" style="font-size:11px">Status</th>
                        <th class="text-muted text-uppercase fw-bold" style="font-size:11px">Date</th>
                        <th class="text-muted text-uppercase fw-bold text-center" style="font-size:11px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($donations as $donation)
                        @php $statusMap = ['completed'=>'bg-success-subtle text-success','pending'=>'bg-warning-subtle text-warning','failed'=>'bg-danger-subtle text-danger','refunded'=>'bg-secondary-subtle text-secondary']; @endphp
                        <tr>
                            <td class="font-monospace text-muted" style="font-size:12px">#{{ $donation->id }}</td>
                            <td>
                                <div class="fw-semibold" style="font-size:12px">{{ $donation->donor_name ?: ($donation->user?->name ?? 'Anonymous') }}</div>
                                <div class="text-muted" style="font-size:11px">{{ $donation->donor_email ?: $donation->user?->email }}</div>
                            </td>
                            <td class="text-muted text-truncate" style="max-width:140px">{{ $donation->campaign?->title ?? '—' }}</td>
                            <td class="text-end fw-bold">${{ number_format($donation->amount / 100, 2) }}</td>
                            <td class="text-center"><span class="badge rounded-pill {{ $statusMap[$donation->status] ?? 'bg-light text-secondary' }}">{{ ucfirst($donation->status) }}</span></td>
                            <td class="text-muted" style="font-size:12px;white-space:nowrap">{{ $donation->created_at->format('M d, Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('admin.donations.show', $donation) }}" class="text-primary fw-semibold text-decoration-none" style="font-size:12px">View</a>
                                    @if($donation->status === 'completed')
                                        <form method="POST" action="{{ route('admin.donations.refund', $donation) }}" class="d-inline" onsubmit="return confirm('Refund this donation?')">@csrf @method('PATCH')
                                            <button class="btn btn-sm btn-link text-danger p-0 fw-semibold text-decoration-none" style="font-size:12px">Refund</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <svg class="mb-2" width="40" height="40" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                <p class="text-muted">No donations found</p>
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
</x-layouts.admin>
