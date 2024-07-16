# Filament plugin for processing JSON field

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pepperfm/filament-json/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pepperfm/filament-json/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)


## Installation

You can install the package via composer:

```bash
composer require pepperfm/filament-json
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="filament-json-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="filament-json-views"
```

## Usage

```php
use PepperFM\FilamentJson\Columns\JsonColumn;

JsonColumn::make('properties');

JsonColumn::make('properties')
    ->asDrawer();

JsonColumn::make('properties')
    ->asModal();
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [PepperFM](https://github.com/pepperfm)

[//]: # (- [All Contributors]&#40;../../contributors&#41;)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
