<?php

use Illuminate\Support\Facades\Route;

// Get controller namespace from config
$controllerNamespace = config('laravel_subscription_managment.controller_namespace', 'Amirhome\LaravelSubscriptionManagment\Http\Controllers');

// Build controller class names
$subscriptionGroupsController = $controllerNamespace . '\SubscriptionGroupsController';
$subscriptionProductsController = $controllerNamespace . '\SubscriptionProductsController';
$subscriptionFeaturesController = $controllerNamespace . '\SubscriptionFeaturesController';
$subscriptionsController = $controllerNamespace . '\SubscriptionsController';


Route::prefix(config('laravel_subscription_managment.path'))
    ->middleware(config('laravel_subscription_managment.middleware'))
    ->group(function () use ($subscriptionGroupsController, $subscriptionProductsController, $subscriptionFeaturesController, $subscriptionsController) {
        // Route::prefix('api')->group(function () {
        //     Route::apiResource('groups', GroupsController::class);
        // });

        // View Welcome Page
        Route::get('/', function () {
            return view('laravel_subscription_managment::index');
        });
        Route::group(['as'=>'ajax.'],function () use ($subscriptionGroupsController, $subscriptionProductsController, $subscriptionFeaturesController, $subscriptionsController) {
            // Subscription Groups
            Route::delete('subscription-groups/mass-destroy', [$subscriptionGroupsController, 'massDestroy'])
                ->name('subscription-groups.massDestroy');
            Route::resource('subscription-groups', $subscriptionGroupsController);
            
            // Subscription Features
            Route::delete('subscription-features/mass-destroy', [$subscriptionFeaturesController, 'massDestroy'])
                ->name('subscription-features.massDestroy');
            Route::resource('subscription-features', $subscriptionFeaturesController);
            
            // Subscription Products with custom route for features
            Route::delete('subscription-products/mass-destroy', [$subscriptionProductsController, 'massDestroy'])
                ->name('subscription-products.massDestroy');
            Route::post('subscription-products/{subscription_product}/features', [$subscriptionProductsController, 'updateProductFeatures'])
                ->name('subscription-products.updateProductFeatures');
            Route::resource('subscription-products', $subscriptionProductsController);
            
            // Subscriptions
            Route::delete('subscriptions/mass-destroy', [$subscriptionsController, 'massDestroy'])
                ->name('subscriptions.massDestroy');
            Route::resource('subscriptions', $subscriptionsController);
        });
        

    });

