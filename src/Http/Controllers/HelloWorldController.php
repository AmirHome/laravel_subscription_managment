<?php

namespace amirhome\HelloWorld\Http\Controllers;

use amirhome\HelloWorld\Models\HelloWorld;
use Illuminate\Contracts\View\View;

class HelloWorldController
{
    public function index(): View
    {
        $message = HelloWorld::first()->message ?? 'Hello World';
        return view('hello_world::index', compact('message'));
    }
} 