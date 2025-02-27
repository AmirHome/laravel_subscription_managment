<?php

namespace amirhome\LaravelSubscriptionManagment;


use Illuminate\Support\ServiceProvider;

class LaravelSubscriptionManagmentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/laravel_subscription_managment.php' => config_path('laravel_subscription_managment.php'),
        ], 'laravel_subscription_managment_config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'laravel_subscription_managment_migrations');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/laravel_subscription_managment'),
        ], 'laravel_subscription_managment_views');

    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel_subscription_managment.php', 'laravel_subscription_managment');
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel_subscription_managment');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel_subscription_managment');

    }
}
