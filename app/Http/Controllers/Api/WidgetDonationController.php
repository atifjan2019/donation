<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDonationRequest;
use App\Http\Controllers\DonationController;
use Illuminate\Http\JsonResponse;

class WidgetDonationController extends Controller
{
    public function store(StoreDonationRequest $request, DonationController $donationController): JsonResponse
    {
        return $donationController->store($request);
    }
}
