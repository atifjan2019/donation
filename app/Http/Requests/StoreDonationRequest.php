<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'campaign_id' => ['nullable', 'exists:campaigns,id'],
            'amount' => ['required', 'integer', 'min:'.config('donation.min_amount', 100), 'max:'.config('donation.max_amount', 100000000)],
            'currency' => ['required', 'string', 'size:3'],
            'payment_method' => ['required', 'in:stripe,paypal'],
            'transaction_id' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:one_time,recurring'],
            'donor_name' => ['required', 'string', 'max:255'],
            'donor_email' => ['required', 'email', 'max:255'],
            'donor_phone' => ['nullable', 'string', 'max:40'],
            'message' => ['nullable', 'string', 'max:4000'],
            'is_anonymous' => ['nullable', 'boolean'],
        ];
    }
}
