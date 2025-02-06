<?php

use Illuminate\Support\Facades\Route;
use amirhome\LaravelSubscriptionManagment\Http\Controllers\LaravelSubscriptionManagmentController;

Route::prefix(config('laravel_subscription_managment.path'))
    ->middleware(config('laravel_subscription_managment.middleware'))
    ->group(function () {
        Route::get('/', [LaravelSubscriptionManagmentController::class, 'index']);
    });
