<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\JsonResponse;

class PublicCampaignController extends Controller
{
    public function index(): JsonResponse
    {
        $campaigns = Campaign::query()
            ->with('categories:id,name,slug')
            ->where('status', 'active')
            ->latest()
            ->paginate(12);

        return response()->json($campaigns);
    }

    public function show(string $slug): JsonResponse
    {
        $campaign = Campaign::query()
            ->with(['categories:id,name,slug'])
            ->where('slug', $slug)
            ->firstOrFail();

        $progress = $campaign->goal_amount > 0
            ? round(($campaign->raised_amount / $campaign->goal_amount) * 100, 2)
            : 0.0;

        return response()->json([
            'campaign' => $campaign,
            'progress_percent' => min($progress, 100),
        ]);
    }
}
