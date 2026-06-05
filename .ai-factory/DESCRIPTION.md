# Project: filament-json

## Overview
A Filament v5 plugin for Laravel that provides a `JsonColumn` table column component for displaying JSON data as tree or table views within inline containers, drawers, or modals. Published as a Composer package on Packagist.

## Core Features
- `JsonColumn` for rendering JSON fields in Filament tables
- Container modes: inline, drawer (`inDrawer()`), modal (`inModal()`), or enum-based `presentIn()`
- Render modes: tree view (`asTree()`) or table view (`asTable()`)
- Configurable button appearance (color, icon, label, size, tooltip) via `ButtonConfigDto`
- Configurable modal properties (icon, alignment, width, close behavior) via `ModalConfigDto`
- DTO-based configuration via `pepperfm/ssd-for-laravel` BaseDto
- UX features: collapsible depth, expand-all toggle, copy JSON action, character limits
- Nested/recursive Blade views for tree rendering
- CSS assets for styling
- Translations support (en)

## Tech Stack
- **Language:** PHP 8.2+
- **Framework:** Laravel (package via spatie/laravel-package-tools)
- **UI Framework:** Filament v5 (Livewire v4-based admin panel)
- **DTO Base:** pepperfm/ssd-for-laravel ^0.2
- **Testing:** Pest v4 with Livewire plugin, Orchestra Testbench ^10.4
- **Static Analysis:** PHPStan ^2.1 / Larastan ^3.0
- **Code Style:** Laravel Pint + PHP CS Fixer

## Architecture Notes
- This is a **Laravel package** (not an application) — follows spatie/laravel-package-tools conventions
- Service provider registers views, config, CSS assets, translations, and commands
- Main component: `JsonColumn` extending Filament's `Column` (not TextColumn)
- Behavior extracted into traits: `HasContainerPresentation`, `HasRenderMode`
- Enums: `ContainerModeEnum` (inline/modal/drawer), `RenderModeEnum` (tree/table)
- DTOs (`ButtonConfigDto`, `ModalConfigDto`) extend `Pepperfm\Ssd\BaseDto`
- DTOs use Filament v5 component-compatible values: `Heroicon` / `Alignment` enums and `Width::...->value` strings where Blade props expect scalar values
- Backward-compatible deprecated API (`asModal()`, `asDrawer()`, `getAsModal()`, `getAsDrawer()`)
- Blade partials: `_partials/tree.blade.php`, `_partials/nested.blade.php` for recursive rendering

## Architecture
See `.ai-factory/ARCHITECTURE.md` for detailed architecture guidelines.
Pattern: Laravel Package (Filament Plugin)

## Non-Functional Requirements
- PHP 8.2+ required
- Must work within Filament v5 / Livewire v4 ecosystem
- Requires Laravel 11.28+ or 12+
- Package auto-discovery via composer extra config
- Backward compatibility with v3 API via deprecated method aliases
