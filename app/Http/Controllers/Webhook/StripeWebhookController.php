<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\RecurringDonation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        if (! $secret) {
            abort(500, 'Stripe webhook secret is not configured.');
        }

        $event = Webhook::constructEvent($payload, $sigHeader, $secret);

        match ($event->type) {
            'payment_intent.succeeded' => $this->markDonationSucceeded($event->data->object),
            'payment_intent.payment_failed' => $this->markDonationFailed($event->data->object),
            'customer.subscription.deleted' => $this->cancelSubscription($event->data->object),
            'charge.dispute.created' => Log::warning('Stripe dispute created', ['event' => $event->id]),
            default => null,
        };

        return response()->json(['received' => true]);
    }

    private function markDonationSucceeded(object $payload): void
    {
        Donation::query()
            ->where('transaction_id', $payload->id)
            ->update([
                'status' => 'completed',
                'paid_at' => now(),
                'gateway_response' => (array) $payload,
            ]);
    }

    private function markDonationFailed(object $payload): void
    {
        Donation::query()
            ->where('transaction_id', $payload->id)
            ->update([
                'status' => 'failed',
                'gateway_response' => (array) $payload,
            ]);
    }

    private function cancelSubscription(object $payload): void
    {
        RecurringDonation::query()
            ->where('stripe_subscription_id', $payload->id)
            ->update([
                'status' => 'cancelled',
            ]);
    }
}
