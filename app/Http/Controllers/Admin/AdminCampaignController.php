<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCampaignController extends Controller
{
    public function index(Request $request): JsonResponse|View
    {
        $campaigns = Campaign::query()->with('categories:id,name,slug')->latest()->paginate(20);

        if ($request->expectsJson()) {
            return response()->json($campaigns);
        }

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function store(StoreCampaignRequest $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;

        $campaign = Campaign::create($data);
        $campaign->categories()->sync($data['category_ids'] ?? []);

        activity()
            ->causedBy($request->user())
            ->performedOn($campaign)
            ->event('admin.campaigns.created')
            ->log('Admin created campaign');

        if (! $request->expectsJson()) {
            return redirect()->route('admin.campaigns.index')->with('status', 'Campaign created successfully.');
        }

        return response()->json($campaign->load('categories'), 201);
    }

    public function show(Request $request, Campaign $campaign): JsonResponse|View
    {
        $campaign->load('categories');

        if ($request->expectsJson()) {
            return response()->json($campaign);
        }

        return response()->json($campaign);
    }

    public function update(UpdateCampaignRequest $request, Campaign $campaign): JsonResponse
    {
        $data = $request->validated();
        $campaign->update($data);

        if (array_key_exists('category_ids', $data)) {
            $campaign->categories()->sync($data['category_ids'] ?? []);
        }

        activity()
            ->causedBy($request->user())
            ->performedOn($campaign)
            ->event('admin.campaigns.updated')
            ->log('Admin updated campaign');

        return response()->json($campaign->load('categories'));
    }

    public function destroy(Request $request, Campaign $campaign): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        activity()
            ->performedOn($campaign)
            ->event('admin.campaigns.deleted')
            ->log('Admin deleted campaign');

        $campaign->delete();

        if (! $request->expectsJson()) {
            return redirect()->route('admin.campaigns.index')->with('status', 'Campaign deleted.');
        }

        return response()->json(['message' => 'Campaign deleted.']);
    }

    public function duplicate(Request $request, Campaign $campaign): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $clone = $campaign->replicate(['slug', 'raised_amount', 'status']);
        $clone->slug = Str::slug($campaign->title.' '.Str::random(6));
        $clone->raised_amount = 0;
        $clone->status = 'paused';
        $clone->save();
        $clone->categories()->sync($campaign->categories()->pluck('categories.id'));

        activity()
            ->performedOn($clone)
            ->event('admin.campaigns.duplicated')
            ->log('Admin duplicated campaign');

        if (! $request->expectsJson()) {
            return redirect()->route('admin.campaigns.index')->with('status', 'Campaign duplicated.');
        }

        return response()->json($clone->load('categories'), 201);
    }
}
