<?php

return [
    'path' => env("SUBSCRIPTION_PATH", "subscriptions"),
    'middleware' => ['web'],
    'table_prefix' => env("SUBSCRIPTION_PREFIX", "saas_"),
    'model_path' => 'Amirhome\LaravelSubscriptionManagment\Models',
    // Number of grace period days added to end_at for validity checks
    'grace_period' => env('SUBSCRIPTION_GRACE_DAYS', 0),
    
    /*
    |--------------------------------------------------------------------------
    | Controller Namespace
    |--------------------------------------------------------------------------
    |
    | This option controls the namespace for subscription controllers.
    | Default: Package controllers (Amirhome\LaravelSubscriptionManagment\Http\Controllers)
    | Override: Set to 'App\Http\Controllers\Admin' to use published controllers
    |
    */
    'controller_namespace' => env('SUBSCRIPTION_CONTROLLER_NAMESPACE', 'Amirhome\LaravelSubscriptionManagment\Http\Controllers'),
];

