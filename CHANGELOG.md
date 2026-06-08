# Changelog

## 5.0.2 - 2026-06-08

### What's Changed

- Respect Filament's native state resolution before JSON normalization, so `state()`, `getStateUsing()`, `default()`, relationship state, separators, and state caching continue to work as expected.
- Decode valid raw JSON strings into structured Tree/Table content while keeping invalid JSON strings renderable as scalar values.
- Preserve valid falsy JSON values such as `false`, `0`, `"0"`, and empty strings.
- Make `filterNullable()` remove only `null` values instead of dropping empty/falsy values.
- Normalize arrays, collections, `Arrayable` values, JSON strings, and scalar values more safely for inline/modal/drawer rendering.
- Harden Blade rendering for scalar states and add regression coverage for computed state, raw JSON strings, nullable filtering, falsy values, and container/render mode combinations.
- Add GitHub Actions checks for tests and PHP code style on the `5.x` branch, and align README badges with the active workflows.

**Full Changelog:** https://github.com/pepperfm/filament-json/compare/5.0.1...5.0.2

## 4.0.1 - 2025-08-17

- Migrate to Filament v4 core APIs (Column вместо TextColumn).
  
- Add `RenderModeEnum` (Tree/Table) и `ContainerModeEnum` (Inline/Modal/Drawer).
  
- Extract sugar into traits:
  
  - `Concerns\HasRenderMode` (asTree/asTable/renderAs/isTree/isTable).
  - `Concerns\HasContainerPresentation` (inModal/inDrawer/inlineContainer/presentIn + BC-методы).
  
- Inline container now **ALWAYS** renders pretty-printed raw JSON (no expand/collapse there).
  
  - Click-to-copy on the raw block (with FilamentNotification feedback).
  
- Modal/Drawer: Tree/Table render preserved; Expand/Collapse toolbar shown only in Tree.
  
- Add table-like headers for Tree mode; aligned with caret; consistent in light/dark themes.
  
- Major Blade rewrite (json.blade.php + _partials/tree/_partials/nested):
  
  - Alpine glue for expand/collapse and copy.
  - Safer `@js` payloads; no invalid Alpine expressions.
  
- New CSS (resources/css/filament-json.css):
  
  - fj-scope variables, soft borders, fj-tree-head, fj-raw, fj-raw-interactive, grid lines.
  - Works with Fi v4 tokens; dark/light polished.
  
- Public API cleanups:
  
  - New: `renderAs()`, `presentIn()`, `getContainerMode()`.
  - Deprecated: `asModal()`, `asDrawer()`, `inline()`, `getAsModal()`, `getAsDrawer()`, `getContainer()`
    (kept for BC; call new methods internally).
  
- `getState()`: normalized arrays/collections with optional null filtering; string limit via characterLimit().
  

BREAKING CHANGE:

- Column now extends `Filament\Tables\Columns\Column` (not TextColumn).
- Inline mode **always** shows raw JSON in-cell; expand/collapse controls are not rendered inline.

## 3.0.11 - 2025-08-17

- added compatibility with Filament 4
- custom styles in `resources/css/filament-json.css`
- `ModalConfigDto` uses `Width` filament's enum

## 2.0.0 - 22-03-2025

### Added feature to display nested data with maxDepth = 2

This json content

```json
{
  "ip": "127.0.0.1",
  "subdata": {
    "1": 321,
    "wow": "123"
  },
  "user_agent": "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36...",
  "fingerprint": null,
  "subDataArray": [
    1,
    2,
    "test"
  ]
}



```
## should look like:

![image](./assets/releases/original.webp)

This json content with this nesting level

```json
{
  "more_nested_array": [
    "scroll_checking",
    "scroll_checking2",
    {
      "scroll_checking_2_1": 1,
      "scroll_checking_2_2": {
        "data": {
          "some_bool_key": true
        }
      }
    }
  ],
  "arrayWithRandomSubData": [
    1,
    "2",
    {
      "1": 1,
      "2": "qweqwe",
      "response": {
        "data": {
          "some_bool_key": true
        }
      }
    }
  ]
}



```
should look like:

![image](./assets/releases/nested.webp)
