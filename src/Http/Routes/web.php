<?php

use Illuminate\Support\Facades\Route;
use Amirhome\LaravelSubscriptionManagment\Http\Controllers\GroupsController;

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
        Route::group(['as'=>'admin.'],function () {
            Route::resource('groups', GroupsController::class);
        });
        

    });
