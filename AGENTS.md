# AGENTS.md

> Project map for AI agents. Keep this file up-to-date as the project evolves.

## Project Overview
Filament v5 plugin for Laravel that provides a `JsonColumn` table column for displaying JSON data as tree or table views in drawers, modals, or inline containers.

## Tech Stack
- **Language:** PHP 8.2+
- **Framework:** Laravel (package via spatie/laravel-package-tools)
- **UI Framework:** Filament v5
- **DTO Base:** pepperfm/ssd-for-laravel
- **Testing:** Pest v4 with Livewire plugin, Orchestra Testbench
- **Static Analysis:** PHPStan / Larastan
- **Code Style:** Laravel Pint + PHP CS Fixer

## Project Structure
```
src/
  Columns/
    JsonColumn.php              # Main column component (extends Filament Column)
  Commands/
    FilamentJsonCommand.php     # Artisan command
  Concerns/
    HasContainerPresentation.php # Trait: modal/drawer/inline container logic
    HasRenderMode.php           # Trait: tree/table render mode logic
  Dto/
    ButtonConfigDto.php         # Button appearance config (extends ssd BaseDto)
    ModalConfigDto.php          # Modal behavior config (extends ssd BaseDto)
  Enums/
    ContainerModeEnum.php       # inline | modal | drawer
    RenderModeEnum.php          # table | tree
  Facades/
    FilamentJson.php            # Laravel facade
  Testing/
    TestsFilamentJson.php       # Testing helpers trait
  FilamentJson.php              # Core service class
  FilamentJsonPlugin.php        # Filament panel plugin registration
  FilamentJsonServiceProvider.php # Package bootstrap
config/
  json.php                      # Publishable configuration
resources/
  css/                          # Source CSS (filament-json.css, index.css)
  dist/                         # Compiled CSS assets
  lang/en/                      # English translations
  views/
    json.blade.php              # Main column view
    _partials/
      tree.blade.php            # Recursive tree rendering
      nested.blade.php          # Nested node rendering
tests/
  src/
    ColumnTest.php              # JsonColumn feature tests
    Fixtures/                   # Test fixtures (BaseTable, ListUsers, etc.)
    Models/
      User.php                  # Test model
  database/
    factories/                  # Test factories
    migrations/                 # Test migrations
  resources/views/              # Test blade fixtures
  ArchTest.php                  # Architecture constraint tests
  Pest.php                      # Pest configuration
  TestCase.php                  # Base test case (Orchestra Testbench)
```

## Key Entry Points
| File | Purpose |
|------|---------|
| `src/Columns/JsonColumn.php` | Main component — the plugin's primary feature |
| `src/FilamentJsonServiceProvider.php` | Package boot — registers views, config, assets |
| `src/FilamentJsonPlugin.php` | Filament panel plugin registration |
| `config/json.php` | Package configuration defaults |
| `composer.json` | Package metadata, dependencies, scripts |

## Scripts
| Command | Purpose |
|---------|---------|
| `composer test` | Run Pest tests |
| `composer analyse` | Run PHPStan static analysis |
| `composer lint` | Check code style (Pint + CS Fixer) |
| `composer lint-hard` | Fix code style |

## AI Context Files
| File | Purpose |
|------|---------|
| AGENTS.md | This file — project structure map |
| .ai-factory/DESCRIPTION.md | Project specification and tech stack |
| .ai-factory/ARCHITECTURE.md | Architecture decisions and guidelines |

## Agent Rules
- Never combine shell commands with `&&`, `||`, or `;` — execute each command as a separate Bash tool call. This applies even when a skill, plan, or instruction provides a combined command — always decompose it into individual calls.
