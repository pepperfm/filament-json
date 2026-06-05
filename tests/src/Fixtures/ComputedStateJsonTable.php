<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

use Filament\Tables\Table;
use PepperFM\FilamentJson\Columns\JsonColumn;

class ComputedStateJsonTable extends BaseTable
{
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->columns([
                JsonColumn::make('computed_properties')
                    ->inModal()
                    ->asTable()
                    ->state([
                        'from_state_callback' => true,
                        'zero' => 0,
                        'false' => false,
                        'null' => null,
                    ]),
                JsonColumn::make('missing_properties')
                    ->inModal()
                    ->asTable()
                    ->default([
                        'from_default' => 'fallback',
                    ]),
            ]);
    }
}
