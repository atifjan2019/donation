<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        activity()
            ->causedBy($request->user())
            ->event('admin.dashboard.viewed')
            ->log('Admin dashboard viewed');

        $today = now()->startOfDay();
        $monthStart = now()->startOfMonth();

        $totalRaisedAllTime = Donation::query()->where('status', 'completed')->sum('amount');
        $totalRaisedMonth = Donation::query()->where('status', 'completed')->where('created_at', '>=', $monthStart)->sum('amount');
        $totalRaisedToday = Donation::query()->where('status', 'completed')->where('created_at', '>=', $today)->sum('amount');

        $donationCount = Donation::count();
        $averageDonation = (int) round((float) Donation::query()->where('status', 'completed')->avg('amount'));

        $topCampaigns = Campaign::query()
            ->withSum(['donations as completed_donations_sum' => fn ($q) => $q->where('status', 'completed')], 'amount')
            ->orderByDesc('completed_donations_sum')
            ->limit(5)
            ->get();

        $revenueChart = Donation::query()
            ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $donorGrowth = User::query()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as total')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $split = Donation::query()
            ->selectRaw('type, COUNT(*) as count, SUM(amount) as total')
            ->where('status', 'completed')
            ->groupBy('type')
            ->get();

        return response()->json([
            'totals' => [
                'all_time' => $totalRaisedAllTime,
                'this_month' => $totalRaisedMonth,
                'today' => $totalRaisedToday,
            ],
            'donation_count' => $donationCount,
            'average_donation' => $averageDonation,
            'top_campaigns' => $topCampaigns,
            'revenue_chart' => $revenueChart,
            'donor_growth_chart' => $donorGrowth,
            'recurring_vs_one_time' => $split,
        ]);
    }
}
