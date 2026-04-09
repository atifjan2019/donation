<x-layouts.admin>
    <x-slot:header>Campaigns</x-slot:header>

    <div class="card">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="font-display fw-bold mb-0">All Campaigns</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle small mb-0">
                    <thead><tr class="border-bottom">
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Title</th>
                        <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Status</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Goal</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Raised</th>
                        <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Actions</th>
                    </tr></thead>
                    <tbody>
                        @forelse($campaigns as $campaign)
                            <tr>
                                <td class="fw-semibold">{{ Str::limit($campaign->title, 35) }}</td>
                                <td>
                                    <span class="badge rounded-pill {{ $campaign->status === 'active' ? 'badge-accent' : 'bg-secondary bg-opacity-10 text-secondary' }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>
                                <td class="text-end">${{ number_format($campaign->goal_amount / 100, 0) }}</td>
                                <td class="text-end fw-bold">${{ number_format($campaign->raised_amount / 100, 0) }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.campaigns.duplicate', $campaign) }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-primary py-1 px-2" style="font-size:11px">Duplicate</button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}" class="d-inline" onsubmit="return confirm('Delete this campaign?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" style="font-size:11px">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">No campaigns yet</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($campaigns->hasPages())
                <div class="mt-4">{{ $campaigns->links() }}</div>
            @endif
        </div>
    </div>
</x-layouts.admin>
