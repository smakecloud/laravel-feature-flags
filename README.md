# An opinionated feature flags package for Laravel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/ryangjchandler/laravel-feature-flags.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/laravel-feature-flags)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/laravel-feature-flags/run-tests?label=tests)](https://github.com/ryangjchandler/laravel-feature-flags/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/ryangjchandler/laravel-feature-flags/Check%20&%20fix%20styling?label=code%20style)](https://github.com/ryangjchandler/laravel-feature-flags/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/ryangjchandler/laravel-feature-flags.svg?style=flat-square)](https://packagist.org/packages/ryangjchandler/laravel-feature-flags)

This package provides an opinionated API for implementing feature flags in your Laravel applications. It supports application-wide features as well as model specific feature flags.

## Installation

You can install the package via Composer:

```bash
composer require ryangjchandler/laravel-feature-flags
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laravel-feature-flags-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-feature-flags-config"
```

## Usage

### Global flags

To enable or disable a global feature flag, you can use the `Features::enable()` and `Features::disable()` methods respectively.

```php
use RyanChandler\LaravelFeatureFlags\Facades\Features;

Features::enable(name: 'registration');
Features::disable(name: 'registration');
```

To check if a flag is enabled or disabled, use the `Features::enabled()` and `Features::disabled()` methods respectively.

```php
use RyanChandler\LaravelFeatureFlags\Facades\Features;

if (Features::enabled(name: 'registration')) {
    // `registration` is enabled.
}

if (Features::disabled(name: 'registration')) {
    // `registration` is disabled.
}
```

If you simply want to toggle a flag, you can use the `Features::toggle()` method.

```php
use RyanChandler\LaravelFeatureFlags\Facades\Features;

Features::toggle(name: 'registration');
```

If the flag is enabled, it will be disabled. If it's disabled, it will be enabled.

### Model flags

If you would like to feature flag specific models, begin by implementing the `RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures` interface and using the `RyanChandler\LaravelFeatureFlags\Models\Concerns\WithFeatures` trait. Here's an example on a `User` model.

```php
use RyanChandler\LaravelFeatureFlags\Models\Contracts\HasFeatures;
use RyanChandler\LaravelFeatureFlags\Models\Concerns\Features;

class User extends Authenticatable implements HasFeatures
{
    use WithFeatures;
}
```

> The trait provides a default implementation that adheres to the interface. It's recommended that you always use this implementation instead of writing your own.

To enable, disable or toggle a flag, use the same `Features::enable()`, `Features::disable()` and `Features::toggle()` methods by providing a named argument `for`.

```php
use RyanChandler\LaravelFeatureFlags\Facades\Features;

$user = User::first();

Features::enable('registration', for: $user);
Features::disable('registration', for: $user);
Features::toggle('registration', for: $user);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Ryan Chandler](https://github.com/ryangjchandler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
