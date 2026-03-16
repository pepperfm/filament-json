<?php

declare(strict_types=1);

use PepperFM\FilamentJson\Columns\JsonColumn;
use PepperFM\FilamentJson\Enums\ContainerModeEnum;
use PepperFM\FilamentJson\Enums\RenderModeEnum;
use PepperFM\FilamentJson\Dto\ButtonConfigDto;
use PepperFM\FilamentJson\Dto\ModalConfigDto;

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
        ->and($column->applyLimit(null))->toBeNull()
        ->and($column->applyLimit(['array']))->toBe(['array']);
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
