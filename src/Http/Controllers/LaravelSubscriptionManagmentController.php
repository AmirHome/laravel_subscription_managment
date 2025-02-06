<?php

namespace amirhome\LaravelSubscriptionManagment\Http\Controllers;

use amirhome\LaravelSubscriptionManagment\Models\LaravelSubscriptionManagment;
use Illuminate\Contracts\View\View;

class LaravelSubscriptionManagmentController
{
    public function index(): View
    {
        $message = LaravelSubscriptionManagment::first()->message ?? 'Hello World';
        return view('laravel_subscription_managment::index', compact('message'));
    }
} 