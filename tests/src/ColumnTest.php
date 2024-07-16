<?php

declare(strict_types=1);

use Filament\Tables;
use PepperFM\FilamentJson\Columns\JsonColumn;
use PepperFM\FilamentJson\Tests\src\Fixtures\BaseTable;
use PepperFM\FilamentJson\Tests\src\Models\User;

use function Pest\Livewire\livewire;

test('can render column', function () {
    $user = User::factory()->make();

    livewire(TestTable::class)
        ->assertSuccessful()
        ->assertCanRenderTableColumn('properties')
        ->assertTableColumnExists('properties')
        ->assertTableColumnStateSet('properties', $user->properties, $user);
});

class TestTable extends BaseTable
{
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('email'),
            JsonColumn::make('properties'),
        ];
    }
}
