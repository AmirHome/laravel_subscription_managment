<?php

namespace amirhome\LaravelSubscriptionManagment\Http\Controllers;

use amirhome\LaravelSubscriptionManagment\Models\Group;
use Illuminate\Contracts\View\View;

class LaravelSubscriptionManagmentController
{
    public function index(): View
    {
        $message = Group::first()->message ?? 'Hello World';
        return view('laravel_subscription_managment::index', compact('message'));
    }
} 