# Hello World Laravel Package

A simple Laravel package demonstrating package development best practices with configurable routes and middleware.

## Installation

```bash
composer require amirhome/hello_world
```

## Configuration

Create a config file in your project:

```bash
php artisan vendor:publish --provider="amirhome\HelloWorld\HelloWorldServiceProvider"

```

## Testing to browser http://127.0.0.1:8000/hello

```bash
composer install
php artisan optimize:clear
php artisan route:list

php artisan serve

```

## License

This package is open-source software licensed under the [MIT License](LICENSE).
