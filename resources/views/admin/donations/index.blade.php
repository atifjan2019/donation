<x-layouts.admin>
    <x-slot:header>Donations</x-slot:header>

    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="font-display fw-bold mb-0">All Donations</h5>
                <a href="{{ route('admin.donations.index', array_merge(request()->query(), ['export' => 'csv'])) }}" class="btn btn-sm btn-outline-primary">Export CSV</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead><tr class="border-bottom">
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">#</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Donor</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Campaign</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Amount</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Status</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Date</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Actions</th>
                    </tr></thead>
                    <tbody>
                        @forelse($donations as $donation)
                            <tr>
                                <td class="text-muted">{{ $donation->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $donation->donor_name ?? 'N/A' }}</div>
                                    <div class="text-muted" style="font-size:11px">{{ $donation->donor_email }}</div>
                                </td>
                                <td>{{ $donation->campaign?->title ? Str::limit($donation->campaign->title, 20) : '—' }}</td>
                                <td class="text-end fw-bold">${{ number_format($donation->amount / 100, 2) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $donation->status === 'completed' ? 'badge-accent' : ($donation->status === 'refunded' ? 'bg-danger bg-opacity-10 text-danger' : 'bg-secondary bg-opacity-10 text-secondary') }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $donation->created_at->format('M d, Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.donations.show', $donation) }}" class="btn btn-sm btn-outline-primary py-1 px-2" style="font-size:11px">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="text-center text-muted py-4">No donations yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($donations->hasPages())
                <div class="mt-4">{{ $donations->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.admin>
