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
            // Subscription Groups
            Route::delete('subscription-groups/mass-destroy', [SubscriptionGroupsController::class, 'massDestroy'])
                ->name('subscription-groups.massDestroy');
            Route::resource('subscription-groups', SubscriptionGroupsController::class);
            
            // Subscription Features
            Route::delete('subscription-features/mass-destroy', [SubscriptionFeaturesController::class, 'massDestroy'])
                ->name('subscription-features.massDestroy');
            Route::resource('subscription-features', SubscriptionFeaturesController::class);
            
            // Subscription Products with custom route for features
            Route::delete('subscription-products/mass-destroy', [SubscriptionProductsController::class, 'massDestroy'])
                ->name('subscription-products.massDestroy');
            Route::post('subscription-products/{subscription_product}/features', [SubscriptionProductsController::class, 'updateProductFeatures'])
                ->name('subscription-products.updateProductFeatures');
            Route::resource('subscription-products', SubscriptionProductsController::class);
            
            // Subscriptions
            Route::delete('subscriptions/mass-destroy', [SubscriptionsController::class, 'massDestroy'])
                ->name('subscriptions.massDestroy');
            Route::resource('subscriptions', SubscriptionsController::class);
        });
        

    });
