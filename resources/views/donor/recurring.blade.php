<x-layouts.donor>
    <x-slot:header>Recurring Donations</x-slot:header>

    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="small text-muted text-uppercase fw-bold" style="font-size:11px">Campaign</th>
                        <th class="small text-muted text-uppercase fw-bold text-end" style="font-size:11px">Amount</th>
                        <th class="small text-muted text-uppercase fw-bold text-center" style="font-size:11px">Frequency</th>
                        <th class="small text-muted text-uppercase fw-bold text-center" style="font-size:11px">Status</th>
                        <th class="small text-muted text-uppercase fw-bold text-center" style="font-size:11px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recurring as $item)
                        @php $statusMap = ['active'=>'bg-success-subtle text-success','paused'=>'bg-warning-subtle text-warning','cancelled'=>'bg-danger-subtle text-danger']; @endphp
                        <tr>
                            <td class="fw-semibold small">{{ $item->campaign?->title ?? 'General Donation' }}</td>
                            <td class="text-end fw-bold small">${{ number_format($item->amount / 100, 2) }}</td>
                            <td class="text-center"><span class="badge bg-light text-secondary rounded-pill text-capitalize">{{ $item->frequency }}</span></td>
                            <td class="text-center"><span class="badge rounded-pill {{ $statusMap[$item->status] ?? 'bg-light text-secondary' }}">{{ ucfirst($item->status) }}</span></td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    @if($item->status === 'active')
                                        <form method="POST" action="{{ route('dashboard.recurring.status', $item->id) }}" class="d-inline">@csrf @method('PATCH')
                                            <input type="hidden" name="status" value="paused">
                                            <button class="btn btn-sm btn-link text-warning p-0 fw-semibold small text-decoration-none">Pause</button>
                                        </form>
                                        <form method="POST" action="{{ route('dashboard.recurring.status', $item->id) }}" class="d-inline">@csrf @method('PATCH')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button class="btn btn-sm btn-link text-danger p-0 fw-semibold small text-decoration-none">Cancel</button>
                                        </form>
                                    @elseif($item->status === 'paused')
                                        <form method="POST" action="{{ route('dashboard.recurring.status', $item->id) }}" class="d-inline">@csrf @method('PATCH')
                                            <input type="hidden" name="status" value="active">
                                            <button class="btn btn-sm btn-link text-success p-0 fw-semibold small text-decoration-none">Resume</button>
                                        </form>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <svg class="mb-2" width="40" height="40" fill="none" stroke="#cbd5e1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <p class="text-muted fw-medium mb-1">No recurring donations yet</p>
                                <a href="{{ route('donations.create') }}" class="text-primary fw-semibold small">Set up a recurring donation →</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($recurring->hasPages())
            <div class="p-3 border-top">{{ $recurring->links() }}</div>
        @endif
    </div>
</x-layouts.donor>
