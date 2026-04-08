<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'currency',
        'payment_method',
        'transaction_id',
        'status',
        'type',
        'campaign_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'message',
        'is_anonymous',
        'gateway_response',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'is_anonymous' => 'boolean',
            'gateway_response' => 'array',
            'paid_at' => 'datetime',
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

    public function receipt(): HasOne
    {
        return $this->hasOne(Receipt::class);
    }
}
