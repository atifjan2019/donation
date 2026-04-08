<?php

return [
    'min_amount' => (int) env('DONATION_MIN_AMOUNT', 100),
    'max_amount' => (int) env('DONATION_MAX_AMOUNT', 100000000),
    'currency' => env('DONATION_DEFAULT_CURRENCY', 'USD'),
    'allow_guest' => (bool) env('DONATION_ALLOW_GUEST', true),
];
