# Architecture: Laravel Package (Filament Plugin)

## Overview
This project follows the **Laravel Package** architecture pattern using `spatie/laravel-package-tools` as its foundation. As a Filament v5 plugin, it extends Filament's table column system with a `JsonColumn` component that supports multiple render modes (tree/table) and container presentations (inline/modal/drawer).

Standard application architectures (Clean, DDD, etc.) don't apply here. Instead, the package follows Composer PSR-4 autoloading conventions, Laravel service provider patterns, and Filament's component extension model.

## Decision Rationale
- **Project type:** Composer package / Filament v5 plugin
- **Tech stack:** PHP 8.2+, Laravel 11.28+/12, Filament v5, Livewire v4
- **Key factor:** Must integrate seamlessly into host Laravel apps via auto-discovery and Filament's plugin system

## Folder Structure
```
src/
  Columns/              # Filament table column components (core feature)
  Commands/             # Artisan console commands
  Concerns/             # Reusable traits (HasContainerPresentation, HasRenderMode)
  Dto/                  # Data Transfer Objects for configuration (extend ssd BaseDto)
  Enums/                # Backed enums (ContainerModeEnum, RenderModeEnum)
  Facades/              # Laravel facade(s)
  Testing/              # Testing helpers/mixins for consumers
  FilamentJson.php      # Core service class (facade target)
  FilamentJsonPlugin.php    # Filament panel plugin registration
  FilamentJsonServiceProvider.php  # Package bootstrap (views, config, CSS assets)
resources/
  css/                  # Source CSS styles
  dist/                 # Compiled/built assets
  lang/                 # Translation files
  views/                # Blade views (main + partials)
config/
  json.php              # Publishable configuration
tests/
  src/                  # Feature tests + fixtures
  database/             # Test migrations and factories
```

## Dependency Rules

### Allowed
- `Columns/` -> `Dto/`, `Concerns/`, `Enums/` (columns compose behavior from traits, DTOs, and enums)
- `Columns/` -> Filament core (`Column`, etc.)
- `Concerns/` -> `Enums/` (traits reference enum types)
- `Dto/` -> `Pepperfm\Ssd\BaseDto` (external DTO base from ssd-for-laravel)
- `Dto/` -> Filament types (`Heroicon`, `Width` enums)
- `ServiceProvider` -> all package classes (composition root)
- `Testing/` -> package classes (test helpers)

### Forbidden
- `Dto/` -> `Columns/` (DTOs must not depend on column components)
- `Enums/` -> anything in `src/` (enums are self-contained value types)
- `Concerns/` -> `Columns/` (traits must not depend on the classes that use them)
- `Columns/` -> `ServiceProvider` (components must not depend on registration)

## Layer Communication
- **Host app -> Package:** Via `JsonColumn::make()` fluent API in Filament table definitions
- **Configuration:** Via DTOs accepting `array|Arrayable|\stdClass` with automatic camelCase mapping (inherited from ssd BaseDto)
- **Behavior composition:** Via traits (`HasContainerPresentation`, `HasRenderMode`) mixed into `JsonColumn`
- **Plugin registration:** Via `FilamentJsonPlugin` implementing Filament's plugin contract
- **View rendering:** Main view delegates to `_partials/tree.blade.php` and `_partials/nested.blade.php` for recursive JSON rendering

## Key Principles

1. **Fluent API consistency** — All column configuration follows Filament's fluent builder pattern (`->inModal()`, `->asTree()`, `->button($config)`)
2. **Enum-driven modes** — Use backed enums (`ContainerModeEnum`, `RenderModeEnum`) instead of boolean flags for multi-state options
3. **Trait-based composition** — Extract orthogonal concerns into traits (`HasContainerPresentation`, `HasRenderMode`) to keep `JsonColumn` focused
4. **Flexible DTO input** — DTOs accept multiple input formats via ssd BaseDto with automatic property mapping
5. **Backward compatibility** — Deprecated methods (`asModal()`, `asDrawer()`) delegate to new API for smooth migration from v3
6. **Filament v5 types** — Use Filament's own enums where component contracts expect them (`Heroicon`, `Alignment`) and enum values where Filament Blade props expect strings (`Width::...->value`)

## Code Examples

### Adding a new column feature
```php
// In src/Columns/JsonColumn.php
// Follow the existing pattern: protected property + fluent setter + getter

protected bool $newFeature = false;

public function newFeature(bool $condition = true): static
{
    $this->newFeature = $condition;

    return $this;
}

public function getNewFeature(): bool
{
    return $this->newFeature;
}
```

### Adding a new enum-based mode
```php
// 1. Create the enum in src/Enums/
enum NewModeEnum: string
{
    case Option1 = 'option1';
    case Option2 = 'option2';
}

// 2. Create a trait in src/Concerns/
trait HasNewMode
{
    protected NewModeEnum $newMode = NewModeEnum::Option1;

    public function newModeAs(NewModeEnum $mode): static
    {
        $this->newMode = $mode;
        return $this;
    }

    public function getNewMode(): NewModeEnum
    {
        return $this->newMode;
    }
}

// 3. Use the trait in JsonColumn
class JsonColumn extends Column
{
    use HasContainerPresentation, HasRenderMode, HasNewMode;
}
```

### Adding a new DTO
```php
// In src/Dto/NewConfigDto.php
// Extend ssd BaseDto (not a local base class)

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

use Pepperfm\Ssd\BaseDto;

class NewConfigDto extends BaseDto
{
    public string $property = 'default';
    public bool $enabled = true;
}

// Usage: NewConfigDto::make(['property' => 'value'])
```

## Anti-Patterns
- Do not add application-level concerns (routing, middleware, authentication) unless the plugin specifically needs them
- Do not use boolean flags for multi-state options — use backed enums instead
- Do not put behavior logic directly in `JsonColumn` when it can be extracted into a trait
- Do not hardcode strings when Filament provides typed enums (e.g., use `Heroicon::OutlinedSwatch` not `'heroicon-o-swatch'`)
- Do not bypass ssd BaseDto's `::make()` factory for DTO instantiation
- Do not add direct database dependencies — this is a UI component package
- Do not reference concrete host-app classes — depend only on Laravel/Filament abstractions
- Do not remove deprecated methods without a major version bump
