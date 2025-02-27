<?php

return [
    'path' => env("SUBSCRIPTION_PATH", "subscriptions"),
    'middleware' => ['web'],
    'table_prefix' => env("SUBSCRIPTION_PREFIX", "saas_"),
    'model_path' => 'Amirhome\LaravelSubscriptionManagment\Models',
];

