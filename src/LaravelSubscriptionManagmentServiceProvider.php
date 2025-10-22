<?php

namespace Amirhome\LaravelSubscriptionManagment;


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

        // Models را publish نمی‌کنیم چون در app/Models سفارشی‌سازی شده‌اند
        // برای publish دستی از tag زیر استفاده کنید:
        // php artisan vendor:publish --tag=laravel_subscription_managment_models
        
        // $this->publishes([
        //     __DIR__ . '/Models/SubscriptionProduct.php' => app_path('Models/SubscriptionProduct.php'),
        //     __DIR__ . '/Models/SubscriptionFeature.php' => app_path('Models/SubscriptionFeature.php'),
        //     __DIR__ . '/Models/SubscriptionGroup.php' => app_path('Models/SubscriptionGroup.php'),
        // ], 'laravel_subscription_managment_models');

        // $this->publishes([
        //     __DIR__ . '/../seeders/SubscriptionSeeder.php' => database_path('seeders/SubscriptionSeeder.php'),
        // ], 'laravel_subscription_managment_seeders');
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel_subscription_managment.php', 'laravel_subscription_managment');
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel_subscription_managment');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel_subscription_managment');
    }
}
