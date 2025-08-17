# Filament JSON Column (v4)

[![Latest Version on Packagist](https://img.shields.io/packagist/v/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)
[![Tests](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/pepperfm/filament-json/actions?query=workflow%3Arun-tests+branch%3Amain)
[![Code Style](https://img.shields.io/github/actions/workflow/status/pepperfm/filament-json/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/pepperfm/filament-json/actions?query=workflow%3A%22Fix+PHP+code+styling%22+branch%3Amain)
[![Downloads](https://img.shields.io/packagist/dt/pepperfm/filament-json.svg?style=flat-square)](https://packagist.org/packages/pepperfm/filament-json)

Beautiful JSON viewer column for **Filament v4** tables.

- **Render modes:** Tree / Table  
- **Presentation modes:** Inline / Modal / Drawer  
- **Inline** shows **pretty-printed raw JSON** (compact, fast) with **click-to-copy**  
- **Modal/Drawer** support **Expand all / Collapse all** (Tree mode) and **Copy JSON**  
- Polished **light/dark** styling. No build steps required for your app.

---

## Installation

```bash
composer require pepperfm/filament-json:^4.0
```

> Previous major versions:
>
> - Filament 3 → `composer require pepperfm/filament-json:^3.0`
> - Filament 2 → `composer require pepperfm/filament-json:^2.0`

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
- **Expand/Collapse** buttons only appear in **Tree** mode, and only for **Modal/Drawer**.
- `maxDepth(int)` controls nesting depth rendering in **Table** mode.
- `filterNullable(true)` filters out null/empty values from arrays/collections.
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
- `filterNullable(bool)` — filter out null/empty values.
- `characterLimit(?int)` — truncate long string values.
- `getContainerMode()` / `isModalContainer()` / `isDrawerContainer()` / `isInlineContainer()` — container checks.

### Backward-compat helpers (deprecated)
Kept for smoother migration — prefer the new API:
- `asModal()` → use `inModal()`
- `asDrawer()` → use `inDrawer()`
- `inline()` → use `inlineContainer()`
- `getAsModal()` / `getAsDrawer()` / `getContainer()` → use `getContainerMode()` or `is*Container()`

---

## Migration from v3 → v4

### TL;DR
- **Inline** now always renders **pretty raw JSON** (with click‑to‑copy).  
  If you need the interactive **Tree** inside a cell — switch to **Modal** or **Drawer** (e.g. `->inDrawer()`).
- Methods renamed for clarity (old ones still work but are deprecated):
    - `asModal()` → `inModal()`
    - `asDrawer()` → `inDrawer()`
    - `inline()` → `inlineContainer()`
    - `getAsModal()/getAsDrawer()/getContainer()` → `getContainerMode()` or `is*Container()`
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
If you test rendering, switch to Filament v4’s **List** resource page approach (per Filament’s docs) and ensure session/error bags are initialized in your test case to avoid `ViewErrorBag` null issues.

---

## Version matrix

- Filament **4.x** → `pepperfm/filament-json:^4.0`
- Filament **3.x** → `pepperfm/filament-json:^3.0`
- Filament **2.x** → `pepperfm/filament-json:^2.0`

Your existing constraints like `^2.x` or `^3.x` will continue to resolve to the proper major — v4 won’t auto-install unless you opt in.

---

## Styling

The package ships a compiled CSS with soft borders, proper light/dark palette, and table grid lines.  
If you publish views and manually tweak Tailwind, ensure your scanner includes the package views (e.g. `resources/views/vendor/filament-json/**/*.blade.php`).

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
    size: Width::Medium
);
$modalConfig = [
    'icon' => Heroicon::OutlinedSwatch,
    'alignment' => 'start',
    'width' => Width::Medium,
    'closedByEscaping' => true,
    'closed_button' => false, // also accepts camel_case
];

JsonColumn::make('properties')
    ->asModal()
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

    public Width $size = Width::Medium;

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

    public Width $width = Width::TwoExtraLarge;

    public bool $closeByClickingAway = true;

    public bool $closedByEscaping = true;

    public bool $closedButton = true;

    public bool $autofocus = true;
}
```

---

## Testing

Skipped for now

[//]: # (- Livewire tests follow the Filament v4 approach &#40;resource list page&#41;.)
[//]: # (- The package’s TestCase initializes session/error bags to avoid null ViewErrorBag issues.)

---

## Changelog

See the GitHub Releases page for a full changelog per version.

---

## Security

If you discover any security-related issues, please email the maintainer instead of using the issue tracker.

---

## Credits

- @pepperfm (author)
- All contributors

---

## License

The MIT License (MIT). See `LICENSE` for details.
