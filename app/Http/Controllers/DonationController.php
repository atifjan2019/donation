<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDonationRequest;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Receipt;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function create(Request $request): JsonResponse|View
    {
        $campaign = null;
        if ($request->filled('campaign_slug')) {
            $campaign = Campaign::query()
                ->where('slug', $request->string('campaign_slug'))
                ->where('status', 'active')
                ->first();
        }

        $payload = [
            'campaign' => $campaign,
            'default_currency' => config('donation.currency', 'USD'),
            'allow_guest' => config('donation.allow_guest', true),
            'preset_amounts' => [1000, 2500, 5000, 10000],
        ];

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('donations.create', $payload);
    }

    public function store(StoreDonationRequest $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();

        if (! $user && ! config('donation.allow_guest', true)) {
            abort(403, 'Guest donations are currently disabled.');
        }

        $donation = DB::transaction(function () use ($request, $user) {
            $payload = $request->validated();
            $payload['user_id'] = $user?->id;
            $payload['status'] = 'completed';
            $payload['paid_at'] = now();
            $payload['transaction_id'] = $payload['transaction_id'] ?? ('txn_'.Str::uuid());

            $donation = Donation::create($payload);

            if (! empty($payload['campaign_id'])) {
                Campaign::query()
                    ->whereKey($payload['campaign_id'])
                    ->increment('raised_amount', $payload['amount']);
            }

            Receipt::create([
                'donation_id' => $donation->id,
                'receipt_number' => 'RCP-'.now()->format('Y').'-'.$donation->id,
            ]);

            return $donation->load(['campaign:id,title,slug', 'receipt']);
        });

        if (! $request->expectsJson()) {
            $redirectTarget = $donation->campaign
                ? route('campaigns.show', $donation->campaign->slug)
                : route('campaigns.index');

            return redirect($redirectTarget)->with('status', 'Donation created successfully. Thank you for your support.');
        }

        return response()->json([
            'message' => 'Donation created successfully.',
            'donation' => $donation,
            'prompt_account_creation' => $user === null,
        ], 201);
    }
}
