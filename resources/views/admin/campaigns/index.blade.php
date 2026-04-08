<x-layouts.admin>
    <x-slot:header>Campaigns</x-slot:header>

    <div class="d-flex align-items-center justify-content-between mb-4">
        <p class="text-muted small mb-0">Manage all campaigns and track their progress.</p>
        <button onclick="document.getElementById('create-form').classList.toggle('d-none')" class="btn btn-gradient btn-sm d-inline-flex align-items-center gap-1">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            New Campaign
        </button>
    </div>

    {{-- Create form --}}
    <div id="create-form" class="d-none card p-4 mb-4" style="border:2px solid #c7d2fe">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="font-display fw-bold mb-0">Create New Campaign</h6>
            <button type="button" onclick="document.getElementById('create-form').classList.add('d-none')" class="btn btn-sm btn-light rounded-circle p-1">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.campaigns.store') }}" class="row g-3">
            @csrf
            <div class="col-sm-6"><label class="form-label small fw-semibold">Title</label><input type="text" name="title" required class="form-control" placeholder="Campaign title"></div>
            <div class="col-sm-6"><label class="form-label small fw-semibold">Slug</label><input type="text" name="slug" required class="form-control" placeholder="campaign-slug"></div>
            <div class="col-12"><label class="form-label small fw-semibold">Description</label><textarea name="description" rows="3" class="form-control" placeholder="Describe the campaign..."></textarea></div>
            <div class="col-sm-6"><label class="form-label small fw-semibold">Goal Amount (cents)</label><input type="number" name="goal_amount" min="100" required class="form-control" placeholder="e.g. 500000 for $5,000"></div>
            <div class="col-sm-6"><label class="form-label small fw-semibold">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="paused">Paused</option></select></div>
            <div class="col-sm-6"><label class="form-label small fw-semibold">Start Date</label><input type="date" name="start_date" class="form-control"></div>
            <div class="col-sm-6"><label class="form-label small fw-semibold">End Date</label><input type="date" name="end_date" class="form-control"></div>
            <div class="col-12 d-flex gap-2 pt-1">
                <button type="submit" class="btn btn-gradient btn-sm">Create Campaign</button>
                <button type="button" onclick="document.getElementById('create-form').classList.add('d-none')" class="btn btn-outline-secondary btn-sm">Cancel</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="card overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="table-light">
                    <tr>
                        <th class="text-muted text-uppercase fw-bold" style="font-size:11px">Campaign</th>
                        <th class="text-muted text-uppercase fw-bold text-end" style="font-size:11px">Goal</th>
                        <th class="text-muted text-uppercase fw-bold text-end" style="font-size:11px">Raised</th>
                        <th class="text-muted text-uppercase fw-bold text-center" style="font-size:11px">Status</th>
                        <th class="text-muted text-uppercase fw-bold" style="font-size:11px">Progress</th>
                        <th class="text-muted text-uppercase fw-bold text-center" style="font-size:11px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                        @php
                            $cGoal = max($campaign->goal_amount, 1);
                            $cProg = min(100, round(($campaign->raised_amount / $cGoal) * 100));
                            $statusMap = ['active'=>'bg-success-subtle text-success','paused'=>'bg-warning-subtle text-warning','completed'=>'bg-info-subtle text-info'];
                        @endphp
                        <tr>
                            <td>
                                <div class="fw-semibold">{{ $campaign->title }}</div>
                                <div class="text-muted font-monospace" style="font-size:11px">/{{ $campaign->slug }}</div>
                            </td>
                            <td class="text-end text-muted">${{ number_format($campaign->goal_amount / 100, 0) }}</td>
                            <td class="text-end fw-bold">${{ number_format($campaign->raised_amount / 100, 0) }}</td>
                            <td class="text-center"><span class="badge rounded-pill {{ $statusMap[$campaign->status] ?? 'bg-light text-secondary' }}">{{ ucfirst($campaign->status) }}</span></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="progress progress-brand" style="width:80px;height:6px"><div class="progress-bar" style="width:{{ $cProg }}%"></div></div>
                                    <span class="fw-bold text-muted" style="font-size:12px">{{ $cProg }}%</span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center gap-2">
                                    <a href="{{ route('campaigns.show', $campaign->slug) }}" target="_blank" class="text-muted" title="View"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg></a>
                                    <form method="POST" action="{{ route('admin.campaigns.duplicate', $campaign) }}" class="d-inline">@csrf<button class="btn btn-sm p-0 text-muted border-0" title="Duplicate"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg></button></form>
                                    <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}" class="d-inline" onsubmit="return confirm('Delete this campaign?')">@csrf @method('DELETE')<button class="btn btn-sm p-0 text-muted border-0" title="Delete"><svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button></form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted">No campaigns yet. Create your first one above.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($campaigns->hasPages())
            <div class="p-3 border-top">{{ $campaigns->links() }}</div>
        @endif
    </div>
</x-layouts.admin>
