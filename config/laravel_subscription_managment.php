<?php

return [
    'path' => env("SUBSCRIPTION_PATH", "subscriptions"),
    'middleware' => ['web'],
    'table_prefix' => env("SUBSCRIPTION_PREFIX", "saas_"),
    'model_path' => 'Amirhome\LaravelSubscriptionManagment\Models',
    // Number of grace period days added to end_at for validity checks
    'grace_period' => env('SUBSCRIPTION_GRACE_DAYS', 0),
];

