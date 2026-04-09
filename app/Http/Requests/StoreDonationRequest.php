<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $min = config('donation.min_amount', 100);
        $max = config('donation.max_amount', 100000000);

        return [
            'amount' => ['required', 'integer', "min:{$min}", "max:{$max}"],
            'currency' => ['sometimes', 'string', 'size:3'],
            'payment_method' => ['required', 'string', 'in:stripe,paypal'],
            'type' => ['required', 'string', 'in:one_time,recurring'],
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['required', 'email', 'max:255'],
            'donor_phone' => ['nullable', 'string', 'max:30'],
            'message' => ['nullable', 'string', 'max:1000'],
            'is_anonymous' => ['nullable', 'boolean'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
        ];
    }
}
