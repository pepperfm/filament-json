<?php

declare(strict_types=1);

use PepperFM\FilamentJson\Columns\JsonColumn;
use PepperFM\FilamentJson\Enums\ContainerModeEnum;
use PepperFM\FilamentJson\Enums\RenderModeEnum;
use PepperFM\FilamentJson\Dto\ButtonConfigDto;
use PepperFM\FilamentJson\Dto\ModalConfigDto;
use Livewire\Livewire;
use PepperFM\FilamentJson\Tests\src\Fixtures\ComputedStateJsonTable;
use PepperFM\FilamentJson\Tests\src\Fixtures\DrawerTreeJsonTable;
use PepperFM\FilamentJson\Tests\src\Fixtures\InlineJsonTable;
use PepperFM\FilamentJson\Tests\src\Fixtures\ModalTableJsonTable;
use PepperFM\FilamentJson\Tests\src\Fixtures\RawJsonStringTable;
use PepperFM\FilamentJson\Tests\src\Models\User;

test('it creates column with default settings', function (): void {
    $column = JsonColumn::make('properties');

    expect($column->getName())->toBe('properties')
        ->and($column->getRenderMode())->toBe(RenderModeEnum::Tree)
        ->and($column->getContainerMode())->toBe(ContainerModeEnum::Drawer)
        ->and($column->getFilterNullable())->toBeTrue()
        ->and($column->getMaxDepth())->toBe(3)
        ->and($column->getCharacterLimit())->toBeNull()
        ->and($column->getInitiallyCollapsed())->toBe(1)
        ->and($column->getExpandAllToggle())->toBeFalse()
        ->and($column->getCopyJsonAction())->toBeTrue();
});

test('it sets render mode', function (): void {
    $column = JsonColumn::make('data');

    $column->renderAs(RenderModeEnum::Table);
    expect($column->getRenderMode())->toBe(RenderModeEnum::Table)
        ->and($column->isTable())->toBeTrue()
        ->and($column->isTree())->toBeFalse();

    $column->asTree();
    expect($column->getRenderMode())->toBe(RenderModeEnum::Tree)
        ->and($column->isTree())->toBeTrue();

    $column->asTable();
    expect($column->isTable())->toBeTrue();
});

test('it sets container mode', function (): void {
    $column = JsonColumn::make('data');

    $column->presentIn(ContainerModeEnum::Modal);
    expect($column->getContainerMode())->toBe(ContainerModeEnum::Modal)
        ->and($column->isModalContainer())->toBeTrue()
        ->and($column->isDrawerContainer())->toBeFalse();

    $column->inDrawer();
    expect($column->isDrawerContainer())->toBeTrue();

    $column->inModal();
    expect($column->isModalContainer())->toBeTrue();

    $column->inlineContainer();
    expect($column->isInlineContainer())->toBeTrue();
});

test('deprecated container methods delegate to new API', function (): void {
    $column = JsonColumn::make('data');

    $column->asModal();
    expect($column->isModalContainer())->toBeTrue()
        ->and($column->getAsModal())->toBeTrue();

    $column->asDrawer();
    expect($column->isDrawerContainer())->toBeTrue()
        ->and($column->getAsDrawer())->toBeTrue();
});

test('it configures UX toggles', function (): void {
    $column = JsonColumn::make('data')
        ->initiallyCollapsed(2)
        ->expandAllToggle()
        ->copyJsonAction(false)
        ->maxDepth(5)
        ->filterNullable(false)
        ->characterLimit(100);

    expect($column->getInitiallyCollapsed())->toBe(2)
        ->and($column->getExpandAllToggle())->toBeTrue()
        ->and($column->getCopyJsonAction())->toBeFalse()
        ->and($column->getMaxDepth())->toBe(5)
        ->and($column->getFilterNullable())->toBeFalse()
        ->and($column->getCharacterLimit())->toBe(100);
});

test('it configures table labels', function (): void {
    $column = JsonColumn::make('data')
        ->keyColumnLabel('Property')
        ->valueColumnLabel('Data');

    expect($column->getKeyColumnLabel())->toBe('Property')
        ->and($column->getValueColumnLabel())->toBe('Data');
});

test('it applies character limit to strings', function (): void {
    $column = JsonColumn::make('data')->characterLimit(10);

    expect($column->applyLimit('short'))->toBe('short')
        ->and($column->applyLimit('this is a very long string'))->toBe('this is a...')
        ->and($column->applyLimit(null))->toBe('null')
        ->and($column->applyLimit(false))->toBe('false')
        ->and($column->applyLimit(true))->toBe('true')
        ->and($column->applyLimit(0))->toBe(0)
        ->and($column->applyLimit(['array']))->toBe(['array']);
});

test('it normalizes state without dropping valid falsy values', function (): void {
    $column = JsonColumn::make('data');

    expect(normalizeJsonColumnState($column, [
        'null' => null,
        'false' => false,
        'zero' => 0,
        'string_zero' => '0',
        'empty_string' => '',
    ]))->toBe([
        'false' => false,
        'zero' => 0,
        'string_zero' => 0,
        'empty_string' => '',
    ]);
});

test('it can keep null values when nullable filtering is disabled', function (): void {
    $column = JsonColumn::make('data')->filterNullable(false);

    expect(normalizeJsonColumnState($column, [
        'null' => null,
        'false' => false,
        'zero' => 0,
    ]))->toBe([
        'null' => null,
        'false' => false,
        'zero' => 0,
    ]);
});

test('it decodes valid json strings and keeps invalid strings unchanged', function (): void {
    $column = JsonColumn::make('data');

    expect(normalizeJsonColumnState($column, '{"alpha":0,"flag":false,"nested":{"label":"kept"}}'))->toBe([
        'alpha' => 0,
        'flag' => false,
        'nested' => [
            'label' => 'kept',
        ],
    ])->and(normalizeJsonColumnState($column, 'not-json'))->toBe('not-json');
});

test('it converts arrayable values recursively', function (): void {
    $column = JsonColumn::make('data');

    expect(normalizeJsonColumnState($column, collect([
        'nested' => collect([
            'zero' => 0,
            'false' => false,
            'null' => null,
        ]),
    ])))->toBe([
        'nested' => [
            'zero' => 0,
            'false' => false,
        ],
    ]);
});

test('it accepts button config', function (): void {
    $column = JsonColumn::make('data')
        ->button(['color' => 'danger', 'label' => 'View']);

    $config = $column->getButtonConfig();

    expect($config)->toBeInstanceOf(ButtonConfigDto::class)
        ->and($config->color)->toBe('danger')
        ->and($config->label)->toBe('View');
});

test('it accepts modal config', function (): void {
    $column = JsonColumn::make('data')
        ->modal(['width' => 'lg', 'closedByEscaping' => false]);

    $config = $column->getModalConfig();

    expect($config)->toBeInstanceOf(ModalConfigDto::class)
        ->and($config->width)->toBe('lg')
        ->and($config->closedByEscaping)->toBeFalse();
});

test('initiallyCollapsed enforces minimum of 0', function (): void {
    $column = JsonColumn::make('data')->initiallyCollapsed(-1);

    expect($column->getInitiallyCollapsed())->toBe(0);
});

test('maxDepth enforces minimum of 1', function (): void {
    $column = JsonColumn::make('data')->maxDepth(0);

    expect($column->getMaxDepth())->toBe(1);
});

test('inline rendering shows pretty json with falsy scalar values', function (): void {
    User::query()->create([
        'name' => 'Inline User',
        'email' => 'inline@example.test',
        'properties' => [
            'zero' => 0,
            'false' => false,
            'text' => 'visible',
            'null' => null,
        ],
    ]);

    Livewire::test(InlineJsonTable::class)
        ->assertSee('"zero": 0')
        ->assertSee('"false": false')
        ->assertSee('"text": "visible"')
        ->assertDontSee('"null": null');
});

test('drawer tree rendering shows decoded json structure and toolbar actions', function (): void {
    User::query()->create([
        'name' => 'Tree User',
        'email' => 'tree@example.test',
        'properties' => [
            'zero' => 0,
            'false' => false,
            'nested' => [
                'label' => 'visible',
            ],
        ],
    ]);

    Livewire::test(DrawerTreeJsonTable::class)
        ->assertSee('Expand all')
        ->assertSee('Collapse all')
        ->assertSee('Copy JSON')
        ->assertSee('zero')
        ->assertSee('false')
        ->assertSee('visible');
});

test('modal table rendering shows custom labels and nested values', function (): void {
    User::query()->create([
        'name' => 'Table User',
        'email' => 'table@example.test',
        'properties' => [
            'zero' => 0,
            'false' => false,
            'nested' => [
                'label' => 'visible',
            ],
        ],
    ]);

    Livewire::test(ModalTableJsonTable::class)
        ->assertSee('Property')
        ->assertSee('Payload')
        ->assertSee('zero')
        ->assertSee('false')
        ->assertSee('nested')
        ->assertSee('visible');
});

test('rendering supports raw json strings from filament state callbacks', function (): void {
    User::query()->create([
        'name' => 'Raw User',
        'email' => 'raw@example.test',
        'properties' => [],
    ]);

    Livewire::test(RawJsonStringTable::class)
        ->assertSee('raw')
        ->assertSee('flag')
        ->assertSee('nested')
        ->assertSee('kept');
});

test('rendering preserves filament state callbacks and defaults', function (): void {
    User::query()->create([
        'name' => 'Computed User',
        'email' => 'computed@example.test',
        'properties' => [],
    ]);

    Livewire::test(ComputedStateJsonTable::class)
        ->assertSee('from_state_callback')
        ->assertSee('true')
        ->assertSee('zero')
        ->assertSee('false')
        ->assertSee('from_default')
        ->assertSee('fallback')
        ->assertDontSee('>null<', escape: false);
});

function normalizeJsonColumnState(JsonColumn $column, mixed $state): mixed
{
    $method = new ReflectionMethod($column, 'normalizeState');
    $method->setAccessible(true);

    return $method->invoke($column, $state);
}
