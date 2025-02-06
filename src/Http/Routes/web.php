<?php

use Illuminate\Support\Facades\Route;
use amirhome\HelloWorld\Http\Controllers\HelloWorldController;

Route::prefix(config('hello_world.path'))
    ->middleware(config('hello_world.middleware'))
    ->group(function () {
        Route::get('/', [HelloWorldController::class, 'index']);
    });
