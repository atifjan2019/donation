<x-layouts.donor>
    <x-slot:header>Donation History</x-slot:header>

    <div class="card">
        <div class="card-body p-4">
            <h5 class="font-display fw-bold mb-4">Your Donations</h5>
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead><tr class="border-bottom">
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Date</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Campaign</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Amount</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Status</th>
                    </tr></thead>
                    <tbody>
                        @forelse($donations as $donation)
                            <tr>
                                <td class="text-muted">{{ $donation->created_at->format('M d, Y') }}</td>
                                <td class="fw-semibold">{{ $donation->campaign?->title ? Str::limit($donation->campaign->title, 25) : 'General' }}</td>
                                <td class="text-end fw-bold">${{ number_format($donation->amount / 100, 2) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $donation->status === 'completed' ? 'badge-accent' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                        {{ ucfirst($donation->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No donations yet. <a href="{{ route('donations.create') }}">Make your first donation!</a></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($donations->hasPages())
                <div class="mt-4">{{ $donations->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.donor>
