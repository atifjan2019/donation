<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class RecurringDonation extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'amount',
        'frequency',
        'payment_method_token',
        'next_charge_date',
        'status',
        'stripe_subscription_id',
        'last_charged_at',
        'failed_attempts',
    ];

    protected function casts(): array
    {
        return [
            'next_charge_date' => 'date',
            'last_charged_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }
}
