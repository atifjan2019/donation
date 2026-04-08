<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCampaignRequest;
use App\Http\Requests\UpdateCampaignRequest;
use App\Models\Campaign;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(
            Campaign::query()->with('categories:id,name,slug')->latest()->paginate(20)
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(StoreCampaignRequest $request): JsonResponse
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

        return response()->json($campaign->load('categories'), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Campaign $campaign): JsonResponse
    {
        return response()->json($campaign->load('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign): JsonResponse
    {
        activity()
            ->performedOn($campaign)
            ->event('admin.campaigns.deleted')
            ->log('Admin deleted campaign');

        $campaign->delete();

        return response()->json(['message' => 'Campaign deleted.']);
    }

    public function duplicate(Campaign $campaign): JsonResponse
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

        return response()->json($clone->load('categories'), 201);
    }
}
