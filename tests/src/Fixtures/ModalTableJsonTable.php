<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

use Filament\Tables\Table;
use PepperFM\FilamentJson\Columns\JsonColumn;

class ModalTableJsonTable extends BaseTable
{
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->columns([
                JsonColumn::make('properties')
                    ->asTable()
                    ->inModal()
                    ->keyColumnLabel('Property')
                    ->valueColumnLabel('Payload'),
            ]);
    }
}
