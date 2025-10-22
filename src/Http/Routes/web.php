<?php

use Illuminate\Support\Facades\Route;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\SubscriptionGroupsController;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\SubscriptionProductsController;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\SubscriptionFeaturesController;
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
            Route::resource('subscription-groups', SubscriptionGroupsController::class);
            
            // Subscription Products with custom route for features
            Route::post('subscription-products/{subscription_product}/features', [SubscriptionProductsController::class, 'updateProductFeatures'])
                ->name('subscription-products.updateProductFeatures');
            Route::resource('subscription-products', SubscriptionProductsController::class);
            
            Route::resource('subscriptions', SubscriptionsController::class);
            Route::resource('subscription-features', SubscriptionFeaturesController::class);
        });
        

    });
