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
            __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel_subscription_managment'),
        ], 'laravel_subscription_managment_views');

        $this->publishes([
            __DIR__ . '/Http/Controllers/SubscriptionGroupsController.php' => app_path('Http/Controllers/Admin/SubscriptionGroupsController.php'),
            __DIR__ . '/Http/Controllers/SubscriptionFeaturesController.php' => app_path('Http/Controllers/Admin/SubscriptionFeaturesController.php'),
            __DIR__ . '/Http/Controllers/SubscriptionProductsController.php' => app_path('Http/Controllers/Admin/SubscriptionProductsController.php'),
            __DIR__ . '/Http/Controllers/SubscriptionsController.php' => app_path('Http/Controllers/Admin/SubscriptionsController.php'),
        ], 'laravel_subscription_managment_controllers');
        
        // Friendly console notice: if the user runs vendor:publish for this package (by tag or provider)
        // print an instruction reminding them to update the published controller namespaces and imports.
        if ($this->app->runningInConsole()) {
            $argv = $_SERVER['argv'] ?? [];
            $argvStr = implode(' ', $argv);
            $tagUsed = str_contains($argvStr, 'laravel_subscription_managment_controllers');
            $providerUsed = str_contains($argvStr, 'LaravelSubscriptionManagmentServiceProvider') || str_contains($argvStr, 'Amirhome\\LaravelSubscriptionManagment\\LaravelSubscriptionManagmentServiceProvider');

            if ($tagUsed || $providerUsed) {
                // Use STDOUT to ensure the message appears in the artisan console output.
                fwrite(STDOUT, PHP_EOL . "IMPORTANT: Published controllers require manual edits.\n");
                fwrite(STDOUT, " - Update namespace to: namespace App\\Http\\Controllers\\Admin;\n");
                fwrite(STDOUT, " - Update base controller import to: use App\\Http\\Controllers\\Controller;\n");
                fwrite(STDOUT, "Please open the published files under app/Http/Controllers/Admin and make these changes so the controllers integrate with your application.\n\n");
            }
        }
    }
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel_subscription_managment.php', 'laravel_subscription_managment');
        $this->loadRoutesFrom(__DIR__ . '/Http/Routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel_subscription_managment');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'laravel_subscription_managment');
    }
}
