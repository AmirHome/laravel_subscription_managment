
![Laravel Subscription Package](https://github.com/user-attachments/assets/9d728593-4315-413a-9990-db9e95d0c6dd)

# Laravel Subscription Managment

laravel_subscription_managment is a flexible plan and subscription management system for Laravel, offering essential tools to efficiently run your SAAS-like services. With a simple architecture and robust foundation, it provides a solid platform to effortlessly manage plans and subscriptions.

## Installation

```bash
composer require amirhome/laravel_subscription_managment
```

### Installation in laravel 11 manually

```json
    "require": {

        "amirhome/laravel_subscription_managment": "@dev"
    },
    "repositories": [
        {
            "type": "path",
            "url": "packages/amirhome/laravel_subscription_managment"
        }
    ],
```

Publish files in your project:

```bash
# (cd ../../../ && composer update && composer dump-autoload -o && php artisan vendor:publish --provider="Amirhome\\LaravelSubscriptionManagment\\LaravelSubscriptionManagmentServiceProvider" --force && php artisan optimize:clear && php artisan migrate:fresh --seed)

php artisan vendor:publish --provider="Amirhome\\LaravelSubscriptionManagment\\LaravelSubscriptionManagmentServiceProvider" --force

composer update
composer dump-autoload
php artisan optimize:clear
php artisan migrate:fresh

php artisan route:list

php artisan serve

```
## Testing to browser http://127.0.0.1:8000/subscriptions

## License

This package is open-source software licensed under the [MIT License](LICENSE).

## Help to publish the package
```bash
git add .
git commit -m "changes"

init_number=1000; build_number=$(($(git rev-list HEAD --count) + init_number)); major=$((build_number / 1000)); minor=$(( (build_number / 10) % 100 )); patch=$((build_number % 10)); version="$major.$minor.$patch"; echo "git tag -a v$version -m \"version $version\""; echo "git push origin master --tags"

git tag -a v0.1.0 -m "version 0.1.0"
git push origin master --tags

```

## Unpublish (Remove Published Files)

If you need to remove all published files from your Laravel project:

```bash
# Remove config file 
rm -f config/laravel_subscription_managment.php

rm -rf resources/views/laravel_subscription_managment
rm -f app/Http/Controllers/Admin/SubscriptionGroupsController.php
rm -f app/Http/Controllers/Admin/SubscriptionFeaturesController.php
rm -f app/Http/Controllers/Admin/SubscriptionProductsController.php
rm -f app/Http/Controllers/Admin/SubscriptionsController.php

# Note: Migrations should be handled carefully
# If you haven't run migrations yet, you can remove them:
# Find and remove migration files starting with dates and containing subscription-related names
# Example: rm -f database/migrations/*_create_subscription_*.php

# Clear cache
php artisan optimize:clear
```