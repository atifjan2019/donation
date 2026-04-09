<x-layouts.donor>
    <x-slot:header>Recurring Donations</x-slot:header>

    <div class="card">
        <div class="card-body p-4">
            <h5 class="font-display fw-bold mb-4">Recurring Donations</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead><tr class="border-bottom">
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Campaign</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Amount</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Frequency</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Status</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Next Charge</th>
                    </tr></thead>
                    <tbody>
                        @forelse($recurring as $sub)
                            <tr>
                                <td class="fw-semibold">{{ $sub->campaign?->title ? Str::limit($sub->campaign->title, 25) : 'General' }}</td>
                                <td class="text-end fw-bold">${{ number_format($sub->amount / 100, 2) }}</td>
                                <td class="text-capitalize">{{ $sub->frequency }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $sub->status === 'active' ? 'badge-accent' : ($sub->status === 'paused' ? 'badge-brand' : 'bg-secondary bg-opacity-10 text-secondary') }}">
                                        {{ ucfirst($sub->status) }}
                                    </span>
                                </td>
                                <td class="text-muted">{{ $sub->next_charge_date?->format('M d, Y') ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No recurring donations yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recurring->hasPages())
                <div class="mt-4">{{ $recurring->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.donor>
