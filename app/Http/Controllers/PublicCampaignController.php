<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class PublicCampaignController extends Controller
{
    public function index(): JsonResponse|View
    {
        $campaigns = Campaign::query()
            ->with('categories:id,name,slug')
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        if (request()->expectsJson()) {
            return response()->json($campaigns);
        }

        return view('campaigns.index', [
            'campaigns' => $campaigns,
        ]);
    }

    public function show(string $slug): JsonResponse|View
    {
        $campaign = Campaign::query()
            ->with(['categories:id,name,slug'])
            ->where('slug', $slug)
            ->firstOrFail();

        $progress = $campaign->goal_amount > 0
            ? round(($campaign->raised_amount / $campaign->goal_amount) * 100, 2)
            : 0.0;

        if (request()->expectsJson()) {
            return response()->json([
                'campaign' => $campaign,
                'progress_percent' => min($progress, 100),
            ]);
        }

        return view('campaigns.show', [
            'campaign' => $campaign,
            'progressPercent' => min($progress, 100),
        ]);
    }
}
