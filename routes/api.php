<?php

use App\Http\Controllers\Api\WidgetCampaignController;
use App\Http\Controllers\Api\WidgetDonationController;
use App\Http\Controllers\Webhook\StripeWebhookController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/widget/campaigns', [WidgetCampaignController::class, 'index']);
    Route::post('/widget/donations', [WidgetDonationController::class, 'store'])->middleware('throttle:30,1');
});

Route::post('/webhooks/stripe', [StripeWebhookController::class, 'handle'])->middleware('throttle:60,1');
