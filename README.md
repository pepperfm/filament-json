# Filament plugin for processing JSON field

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pepperfm/filament-json/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pepperfm/filament-json/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)


# [Documentation on my doc. website](https://docs.pepperfm.com/filament-json)

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

### Customize button and modal props:
```php
use PepperFM\FilamentJson\Columns\JsonColumn;

$buttonConfig = [
    'color' => 'warning',
    'size' => 'xs',
];
$modalConfig = literal(
    icon: 'heroicon-m-sparkles',
    alignment: 'start',
    width: 'xl',
    closedButton: false,
);

JsonColumn::make('properties')
    ->asModal()
    ->button($buttonConfig)
    ->modal($modalConfig);
```
> [!IMPORTANT]
> The `button()` and `modal()` method accept the type of `array|Arrayable|\stdClass`, and implements basic properties of button and modal blade components from Filament documentation: Core Concepts - Blade Components

#### DTO schemas of components configuration:
```php
class ButtonConfigDto
{
    public string $color = 'primary';

    public string $icon = 'heroicon-o-swatch';

    public ?string $label = null;

    public ?string $tooltip = null;

    public string $size = 'md';

    public ?string $href = null;

    public ?string $tag = null;
}
```
```php
class ModalConfigDto
{
    public ?string $id = null;

    public string $icon = 'heroicon-o-swatch';

    public string $iconColor = 'primary';

    public string $alignment = 'start';

    public string $width = 'xl';

    public bool $closeByClickingAway = true;

    public bool $closedByEscaping = true;

    public bool $closedButton = true;

    public bool $autofocus = true;
}
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
