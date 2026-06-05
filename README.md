# Filament JSON Column (v5)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)
[![Tests](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/run-tests.yml?branch=5.x&label=tests&style=flat-square)](https://github.com/pepperfm/filament-json/actions/workflows/run-tests.yml?query=branch%3A5.x)
[![Code Style](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/fix-php-code-styling.yml?branch=5.x&label=code%20style&style=flat-square)](https://github.com/pepperfm/filament-json/actions/workflows/fix-php-code-styling.yml?query=branch%3A5.x)
[![Downloads](https://img.shields.io/packagist/dt/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)

Beautiful JSON viewer column for **Filament v5** tables.

- **Render modes:** Tree / Table  
- **Presentation modes:** Inline / Modal / Drawer  
- **Inline** shows **pretty-printed raw JSON** (compact, fast) with **click-to-copy**  
- **Modal/Drawer** support **Expand all / Collapse all** (Tree mode) and **Copy JSON**  
- Polished **light/dark** styling. No build steps required for your app.

---

## Installation

### [Documentation on my doc. website](https://docs.pepperfm.com/filament-json)

```bash
composer r pepperfm/filament-json:^5.0
```

> Previous major versions:
>
> - Filament 4 → `composer r pepperfm/filament-json:^4.0` or `^3.0`
> - Filament 3 → `composer r pepperfm/filament-json:^2.0`

Optionally publish config or views if you want to customize them:

```bash
php artisan vendor:publish --tag="filament-json-config"
php artisan vendor:publish --tag="filament-json-views"
```

No Tailwind/Vite setup is required — the package ships a compiled stylesheet and registers it via Filament assets.

---

## Quick start

```php
use PepperFM\FilamentJson\Columns\JsonColumn;
use PepperFM\FilamentJson\Enums\{RenderModeEnum, ContainerModeEnum};

// Inline (in-cell): always pretty raw JSON with click-to-copy
JsonColumn::make('properties')
    ->renderAs(RenderModeEnum::Tree) // used if you later switch to modal/drawer
    ->presentIn(ContainerModeEnum::Inline);

// Tree in a Drawer (with toolbar)
JsonColumn::make('properties')
    ->renderAs(RenderModeEnum::Tree)
    ->presentIn(ContainerModeEnum::Drawer)
    ->initiallyCollapsed(1)
    ->expandAllToggle() // Tree only (modal/drawer)
    ->copyJsonAction(false); // hide Copy button

// Table mode in a Modal with custom headers
JsonColumn::make('properties')
    ->renderAs(RenderModeEnum::Table)
    ->presentIn(ContainerModeEnum::Modal)
    ->keyColumnLabel('Custom Key Label')
    ->valueColumnLabel('Custom Value Label');
```

### Sugar aliases

```php
// Content render mode:
->asTree() // = renderAs(RenderModeEnum::Tree)
->asTable() // = renderAs(RenderModeEnum::Table)

// Container presentation:
->inlineContainer() // = presentIn(ContainerModeEnum::Inline)
->inModal() // = presentIn(ContainerModeEnum::Modal)
->inDrawer() // = presentIn(ContainerModeEnum::Drawer)
```

---

## Behavior & UX

- **Inline** container always renders a **pretty-printed raw JSON block** directly in the cell.  
  Click the block (or press Enter/Space when focused) to copy JSON to clipboard.
- Raw JSON strings are decoded when they contain valid JSON, so string database values such as
  `{"key":"value"}` can still render as structured Tree/Table content.
- **Expand/Collapse** buttons only appear in **Tree** mode, and only for **Modal/Drawer**.
- `maxDepth(int)` controls nesting depth rendering in **Table** mode.
- `filterNullable(true)` filters out `null` values from arrays/collections.
  It preserves valid JSON falsy values like `false`, `0`, `"0"`, and empty strings.
- `characterLimit(?int)` truncates long string scalars.

---

## Modal / Drawer toolbar

In modal/drawer modes you can enable a small toolbar above the content:

```php
JsonColumn::make('properties')
    ->asTree()
    ->inDrawer()
    ->expandAllToggle() // adds Expand all / Collapse all buttons
    ->copyJsonAction(false); // hide Copy JSON button
```

---

## Labels (Table mode)

```php
JsonColumn::make('properties')
    ->asTable()
    ->inModal()
    ->keyColumnLabel('Key')
    ->valueColumnLabel('Value');
```

---

## API reference (selected)

- `renderAs(RenderModeEnum::Tree|Table)` — choose how JSON is rendered.
- `presentIn(ContainerModeEnum::Inline|Modal|Drawer)` — choose where it is presented.
- `asTree()`, `asTable()` — sugar for `renderAs(...)`.
- `inlineContainer()`, `inModal()`, `inDrawer()` — sugar for `presentIn(...)`.
- `initiallyCollapsed(int $depth = 1)` — auto-collapse depth for Tree.
- `expandAllToggle(bool $on = true)` — toggle Tree toolbar buttons (modal/drawer).
- `copyJsonAction(bool $on = true)` — toggle Copy JSON button (modal/drawer).
- `keyColumnLabel(string)`, `valueColumnLabel(string)` — Table headers.
- `maxDepth(int)` — nesting limit for Table mode nested blocks.
- `filterNullable(bool)` — filter out `null` values while preserving falsy JSON scalars.
- `characterLimit(?int)` — truncate long string values.
- `getContainerMode()` / `isModalContainer()` / `isDrawerContainer()` / `isInlineContainer()` — container checks.

---

## Migration from v4 → v5

Filament v5 has no breaking API changes — it adds Livewire v4 support. The upgrade is straightforward:

```bash
composer require pepperfm/filament-json:^5.0
```

No code changes required. All existing `JsonColumn` configuration works as-is.

**Requirements:**
- PHP 8.2+
- Laravel 11.28+ or 12+
- Filament 5.x

---

## Migration from v3 → v4

### TL;DR
- **Inline** now always renders **pretty raw JSON** (with click‑to‑copy).  
  If you need the interactive **Tree** inside a cell — switch to **Modal** or **Drawer** (e.g. `->inDrawer()`).
- Methods renamed for clarity (old ones still work but are deprecated):
    - `asModal()` → `inModal()`
    - `asDrawer()` → `inDrawer()`
    - `inline()` → `inlineContainer()`
    - `getAsModal()/getAsDrawer()/getContainer()` → `getContainerMode()` or `isInlineContainer()`
- No app-side asset build is required anymore — the package ships compiled CSS.

### Before (v3)
```php
JsonColumn::make('properties')
    ->asTree()
    ->asDrawer()
    ->initiallyCollapsed()
    ->filterNullable();
```

### After (v4)
```php
use PepperFM\FilamentJson\Enums\{RenderModeEnum, ContainerModeEnum};

JsonColumn::make('properties')
    ->renderAs(RenderModeEnum::Tree)
    ->presentIn(ContainerModeEnum::Drawer)
    ->initiallyCollapsed()
    ->filterNullable(true);
```

### Inline behavior change
If you previously relied on Tree/Table **inline** (inside the cell), note that v4 renders **pretty JSON** instead.  
To keep the interactive view, present it in a modal or drawer:

```php
JsonColumn::make('properties')
    ->asTree()
    ->inDrawer(); // or ->inModal()
```

### Optional toolbar
In modal/drawer Tree mode you can show a small toolbar:

```php
JsonColumn::make('properties')
    ->asTree()
    ->inDrawer()
    ->expandAllToggle() // Expand all / Collapse all buttons
    ->copyJsonAction(false); // Hide copy JSON button
```

### Testing adjustments
If you test rendering, use a Filament **List** resource page fixture and ensure session/error bags are initialized in your test case to avoid `ViewErrorBag` null issues.

---

## Version matrix

- Filament **5.x** → `pepperfm/filament-json:^5.0`
- Filament **4.x** → `pepperfm/filament-json:^4.0` or `^3.0`
- Filament **3.x** → `pepperfm/filament-json:^2.0`

Your existing constraints like `^3.x` or `^4.x` will continue to resolve to the proper major — v5 won’t auto-install unless you opt in.

---

## Styling

The package ships a compiled CSS with soft borders, proper light/dark palette, and table grid lines.  
If you publish views and manually tweak Tailwind, ensure your scanner includes the package views (e.g. `resources/views/vendor/filament-json/**/*.blade.php`).

---

## Package extension points

The package keeps a small facade target, an empty publishable config file, and a Livewire testing
mixin registration for backward compatibility and future package-level helpers. The primary public
API remains `JsonColumn::make(...)->...`.

---

### Customize button and modal props
> [!IMPORTANT]
> The `button()` and `modal()` method accept the type of `array|Arrayable|\stdClass`, and implements basic properties of button and modal blade components from Filament documentation: Core Concepts - Blade Components

```php
use PepperFM\FilamentJson\Columns\JsonColumn;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

$buttonConfig = literal(
    color: 'primary',
    size: Width::Medium->value
);
$modalConfig = [
    'icon' => Heroicon::OutlinedSwatch,
    'alignment' => 'start',
    'width' => Width::Medium->value,
    'closedByEscaping' => true,
    'closed_button' => false, // also accepts camel_case
];

JsonColumn::make('properties')
    ->inModal()
    ->button($buttonConfig)
    ->modal($modalConfig);
```
#### DTO schemas of components configuration:
```php
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class ButtonConfigDto extends \Pepperfm\Ssd\BaseDto
{
    public string $color = 'primary';

    public Heroicon $icon = Heroicon::OutlinedSwatch;

    public ?string $label = null;

    public ?string $tooltip = null;

    public string $size = Width::Medium->value;

    public ?string $href = null;

    public ?string $tag = null;
}
```

```php
use Filament\Support\Icons\Heroicon;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Width;

class ModalConfigDto extends \Pepperfm\Ssd\BaseDto
{
    public ?string $id = null;

    public Heroicon $icon = Heroicon::Sparkles;

    public string $iconColor = 'primary';

    public Alignment $alignment = Alignment::Start;

    public string $width = Width::TwoExtraLarge->value;

    public bool $closeByClickingAway = true;

    public bool $closedByEscaping = true;

    public bool $closedButton = true;

    public bool $autofocus = true;
}
```

---

## Testing

```bash
composer test
composer analyse
composer lint
```

The test suite uses Pest v4, Orchestra Testbench, and Filament resource fixtures to cover the column API and package integration points.

---

## Changelog

See the GitHub Releases page for a full changelog per version.

---

## Security

If you discover any security-related issues, please email the maintainer instead of using the issue tracker.
When debugging host-application data, avoid logging raw JSON payloads unless you have reviewed them
for secrets or personal data.

---

## Credits

- @pepperfm (author)
- All contributors

---

## License

The MIT License (MIT). See `LICENSE` for details.
