
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
php artisan vendor:publish --provider="amirhome\LaravelSubscriptionManagment\LaravelSubscriptionManagmentServiceProvider"

```

## Testing to browser http://127.0.0.1:8000/subscriptions

```bash
composer update
composer dump-autoload
php artisan optimize:clear
php artisan migrate
php artisan route:list

php artisan serve

```

## License

This package is open-source software licensed under the [MIT License](LICENSE).
