<?php

namespace amirhome\HelloWorld;

use amirhome\HelloWorld\Http\Controllers\HelloWorldController;
use Illuminate\Support\ServiceProvider;

class HelloWorldServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/hello_world.php' => config_path('hello_world.php'),
        ], 'hello_world_config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'hello_world_migrations');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/hello_world'),
        ], 'hello_world_views');
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/hello_world.php', 'hello_world');
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'hello_world');

    }
}
