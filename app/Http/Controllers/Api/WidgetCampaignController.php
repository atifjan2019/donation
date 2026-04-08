<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;

class WidgetCampaignController extends Controller
{
    public function index(): JsonResponse
    {
        $campaigns = Campaign::query()
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->get(['id', 'title', 'slug', 'goal_amount', 'raised_amount']);

        return response()->json(['data' => $campaigns]);
    }
}
