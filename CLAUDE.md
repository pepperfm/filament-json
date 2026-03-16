# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

Filament v4 plugin (Laravel/Composer package) that provides `JsonColumn` — a table column for rendering JSON data as tree or table views in inline containers, drawers, or modals.

## Commands

```bash
composer test                  # Run Pest tests
composer test -- --filter=Name # Run a single test by name
composer analyse               # PHPStan static analysis (level 5)
composer lint                  # Check code style (Pint + PHP CS Fixer)
composer lint-hard             # Fix code style
npm run build                  # Build Tailwind CSS to resources/dist/
```

## Architecture

**JsonColumn** (`src/Columns/JsonColumn.php`) extends Filament's `Column` (not TextColumn). It composes behavior via two traits:

- `HasContainerPresentation` — controls where JSON is displayed: inline, modal, or drawer (`ContainerModeEnum`)
- `HasRenderMode` — controls how JSON is displayed: tree or table (`RenderModeEnum`)

Both traits use backed enums instead of boolean flags. Deprecated v3 methods (`asModal()`, `asDrawer()`, `getAsModal()`, `getAsDrawer()`) delegate to the new enum-based API for backward compatibility.

**DTOs** (`ButtonConfigDto`, `ModalConfigDto`) extend `Pepperfm\Ssd\BaseDto` from `pepperfm/ssd-for-laravel`. They accept `array|Arrayable|\stdClass` with automatic camelCase property mapping. DTOs use Filament v4 typed enums (`Heroicon`, `Width`) rather than raw strings.

**Views** use recursive Blade partials: `json.blade.php` → `_partials/tree.blade.php` → `_partials/nested.blade.php`. Interactive features (copy JSON, expand/collapse) use Alpine.js.

**Service Provider** uses `spatie/laravel-package-tools` to register views, config, CSS assets, translations, and commands. CSS is compiled via Tailwind and registered through `FilamentAsset`.

## Testing

Tests use Pest v3 with Orchestra Testbench and Livewire plugin. Test infrastructure:
- `tests/TestCase.php` — registers Filament providers/plugins, configures SQLite in-memory DB, loads test migrations
- `tests/src/Fixtures/` — UserResource, ListUsers, BaseTable, TestPanelProvider for Filament testing
- `tests/src/Models/User.php` — test model with `properties` JSON cast

## Code Style

Two tools enforce style — both must pass:
- **Laravel Pint** (`pint.json`) — Laravel preset
- **PHP CS Fixer** (`.php-cs-fixer.php`) — @Symfony + @PSR12 + @PHP80Migration rules

All source files use `declare(strict_types=1)`.

## Conventions

- New column features follow the pattern: `protected` property → fluent setter returning `static` → getter with `get` prefix
- Multi-state options use backed enums + dedicated traits in `src/Concerns/`, not boolean flags on JsonColumn
- DTOs go in `src/Dto/` and must extend `Pepperfm\Ssd\BaseDto`
- Architecture tests (`tests/ArchTest.php`) forbid `dd`, `dump`, `ray`, and `env()` usage in source
