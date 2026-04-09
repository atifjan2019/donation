<x-layouts.admin>
    <x-slot:header>Dashboard</x-slot:header>

    <div class="row g-3 mb-4">
        @foreach([
            ['Total Raised', '$'.number_format($totals['all_time'] / 100, 2), 'All time', '#DB7C1C', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1','#fef3e2'],
            ['This Month', '$'.number_format($totals['this_month'] / 100, 2), 'Current month', '#27ae60', 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6','#ecfdf5'],
            ['Total Donations', number_format($donation_count), 'All time count', '#DB7C1C', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z','#fef9f0'],
            ['Avg. Donation', '$'.number_format($average_donation / 100, 2), 'Per donation', '#4b5563', 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z','#f3f4f6'],
        ] as $s)
            <div class="col-sm-6 col-xl-3">
                <div class="card stat-card p-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-muted text-uppercase fw-bold" style="font-size:11px;letter-spacing:0.08em">{{ $s[0] }}</div>
                            <div class="font-display fw-bold fs-4 mt-2">{{ $s[1] }}</div>
                            <div class="text-muted mt-1" style="font-size:12px">{{ $s[2] }}</div>
                        </div>
                        <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:{{ $s[5] }}">
                            <svg width="20" height="20" fill="none" stroke="{{ $s[3] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $s[4] }}"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="font-display fw-bold mb-0">Top Campaigns</h6>
                    <a href="{{ route('admin.campaigns.index') }}" class="text-primary fw-semibold small text-decoration-none">View all →</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 small">
                        <thead><tr class="border-bottom">
                            <th class="text-muted text-uppercase fw-bold py-2" style="font-size:11px">Campaign</th>
                            <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Raised</th>
                            <th class="text-muted text-uppercase fw-bold py-2 text-end d-none d-sm-table-cell" style="font-size:11px">Goal</th>
                            <th class="text-muted text-uppercase fw-bold py-2 text-end" style="font-size:11px">Progress</th>
                        </tr></thead>
                        <tbody>
                            @forelse($top_campaigns as $tc)
                                @php $cGoal = max($tc->goal_amount, 1); $cProg = min(100, round(($tc->completed_donations_sum ?? 0) / $cGoal * 100)); @endphp
                                <tr>
                                    <td class="fw-semibold">{{ Str::limit($tc->title, 28) }}</td>
                                    <td class="text-end fw-bold">${{ number_format(($tc->completed_donations_sum ?? 0) / 100, 0) }}</td>
                                    <td class="text-end text-muted d-none d-sm-table-cell">${{ number_format($tc->goal_amount / 100, 0) }}</td>
                                    <td class="text-end">
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <div class="progress progress-brand d-none d-sm-flex" style="width:60px;height:6px">
                                                <div class="progress-bar" style="width:{{ $cProg }}%"></div>
                                            </div>
                                            <span class="fw-bold text-muted" style="width:36px;text-align:right">{{ $cProg }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">No campaigns yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4">
                <h6 class="font-display fw-bold mb-3">Donation Split</h6>
                <div class="d-flex flex-column gap-2">
                    @forelse($recurring_vs_one_time as $item)
                        <div class="d-flex justify-content-between align-items-center rounded-4 px-3 py-3" style="background:#f9fafb">
                            <div>
                                <div class="fw-semibold small text-capitalize">{{ str_replace('_', ' ', $item->type) }}</div>
                                <div class="text-muted" style="font-size:12px">{{ $item->count }} {{ Str::plural('donation', $item->count) }}</div>
                            </div>
                            <div class="font-display fw-bold small">${{ number_format($item->total / 100, 0) }}</div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4 small">No data available</p>
                    @endforelse
                </div>
                <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted" style="font-size:12px">Today's Total</div>
                        <div class="font-display fw-bold fs-5 mt-1">${{ number_format($totals['today'] / 100, 2) }}</div>
                    </div>
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:40px;height:40px;background:#ecfdf5">
                        <svg width="20" height="20" fill="none" stroke="#27ae60" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        @foreach([
            [route('admin.donations.index'), 'All Donations', 'Manage and export', '#DB7C1C', '#fef3e2', 'M4 6h16M4 10h16M4 14h16M4 18h16'],
            [route('admin.campaigns.index'), 'Manage Campaigns', 'Create or edit', '#27ae60', '#ecfdf5', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
            [route('admin.donations.index', array_merge(request()->query(), ['export' => 'csv'])), 'Export CSV', 'Download all donations', '#4b5563', '#f3f4f6', 'M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
        ] as $a)
            <div class="col-sm-4">
                <a href="{{ $a[0] }}" class="card card-hover text-decoration-none p-4 d-flex flex-row align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width:44px;height:44px;background:{{ $a[4] }}">
                        <svg width="20" height="20" fill="none" stroke="{{ $a[3] }}" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $a[5] }}"/></svg>
                    </div>
                    <div>
                        <div class="fw-semibold small text-dark">{{ $a[1] }}</div>
                        <div class="text-muted" style="font-size:12px">{{ $a[2] }}</div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</x-layouts.admin>
