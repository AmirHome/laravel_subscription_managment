<?php

use Illuminate\Support\Facades\Route;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\GroupsController;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\ProductsController;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\FeaturesController;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\SubscriptionsController;


Route::prefix(config('laravel_subscription_managment.path'))
    ->middleware(config('laravel_subscription_managment.middleware'))
    ->group(function () {
        // Route::prefix('api')->group(function () {
        //     Route::apiResource('groups', GroupsController::class);
        // });

        // View Welcome Page
        Route::get('/', function () {
            return view('laravel_subscription_managment::index');
        });
        Route::group(['as'=>'ajax.'],function () {
            Route::resource('subscription_groups', GroupsController::class);
            Route::resource('subscription_products', ProductsController::class);
            Route::resource('subscriptions', SubscriptionsController::class);
            Route::resource('subscription_features', FeaturesController::class);

        });
        

    });
