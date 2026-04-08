<x-layouts.admin>
    <x-slot:header>Campaigns</x-slot:header>

    <div class="flex items-center justify-between mb-6">
        <p class="text-sm text-gray-500">Manage all campaigns and track their progress.</p>
        <button onclick="document.getElementById('create-form').classList.toggle('hidden')"
                class="btn-primary !py-2 !px-5 text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
            New Campaign
        </button>
    </div>

    {{-- ── Create form ────────────────────────────────────────── --}}
    <div id="create-form" class="hidden card p-6 mb-6 border-2 border-brand-100">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-display font-semibold text-gray-900">Create New Campaign</h3>
            <button type="button" onclick="document.getElementById('create-form').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.campaigns.store') }}" class="grid sm:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="form-label !text-xs">Title</label>
                <input type="text" name="title" required class="form-input" placeholder="Campaign title">
            </div>
            <div>
                <label class="form-label !text-xs">Slug</label>
                <input type="text" name="slug" required class="form-input" placeholder="campaign-slug">
            </div>
            <div class="sm:col-span-2">
                <label class="form-label !text-xs">Description</label>
                <textarea name="description" rows="3" class="form-input" placeholder="Describe the campaign..."></textarea>
            </div>
            <div>
                <label class="form-label !text-xs">Goal Amount (cents)</label>
                <input type="number" name="goal_amount" min="100" required class="form-input" placeholder="e.g. 500000 for $5,000">
            </div>
            <div>
                <label class="form-label !text-xs">Status</label>
                <select name="status" class="form-select">
                    <option value="active">Active</option>
                    <option value="paused">Paused</option>
                </select>
            </div>
            <div>
                <label class="form-label !text-xs">Start Date</label>
                <input type="date" name="start_date" class="form-input">
            </div>
            <div>
                <label class="form-label !text-xs">End Date</label>
                <input type="date" name="end_date" class="form-input">
            </div>
            <div class="sm:col-span-2 flex gap-3 pt-2">
                <button type="submit" class="btn-primary !py-2 !px-5 text-sm">Create Campaign</button>
                <button type="button" onclick="document.getElementById('create-form').classList.add('hidden')"
                        class="btn-ghost !py-2 !px-5 text-sm border border-gray-200">Cancel</button>
            </div>
        </form>
    </div>

    {{-- ── Table ─────────────────────────────────────────────── --}}
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50/80 border-b border-gray-100">
                    <tr>
                        <th class="th">Campaign</th>
                        <th class="th-right">Goal</th>
                        <th class="th-right">Raised</th>
                        <th class="th-center">Status</th>
                        <th class="th">Progress</th>
                        <th class="th-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($campaigns as $campaign)
                        @php
                            $cGoal = max($campaign->goal_amount, 1);
                            $cProg = min(100, round(($campaign->raised_amount / $cGoal) * 100));
                            $statusMap = [
                                'active'    => 'badge-green',
                                'paused'    => 'badge-yellow',
                                'completed' => 'badge-blue',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50/60 transition-colors">
                            <td class="td">
                                <p class="font-semibold text-gray-900">{{ $campaign->title }}</p>
                                <p class="text-xs text-gray-400 mt-0.5 font-mono">/{{ $campaign->slug }}</p>
                            </td>
                            <td class="td-right text-gray-500">${{ number_format($campaign->goal_amount / 100, 0) }}</td>
                            <td class="td-right font-bold text-gray-900">${{ number_format($campaign->raised_amount / 100, 0) }}</td>
                            <td class="td-center">
                                <span class="badge {{ $statusMap[$campaign->status] ?? 'badge-gray' }}">
                                    {{ ucfirst($campaign->status) }}
                                </span>
                            </td>
                            <td class="td">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-brand-500 to-accent-500 rounded-full" style="width: {{ $cProg }}%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-500">{{ $cProg }}%</span>
                                </div>
                            </td>
                            <td class="td-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('campaigns.show', $campaign->slug) }}" target="_blank"
                                       class="text-gray-400 hover:text-brand-600 transition-colors" title="View public page">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.campaigns.duplicate', $campaign) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-accent-600 transition-colors" title="Duplicate">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.campaigns.destroy', $campaign) }}"
                                          class="inline" onsubmit="return confirm('Delete this campaign?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="td text-center py-16">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                    No campaigns yet. Create your first one above.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($campaigns->hasPages())
            <div class="px-5 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $campaigns->links() }}
            </div>
        @endif
    </div>
</x-layouts.admin>
