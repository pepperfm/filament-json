<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

use Filament\Tables\Table;
use PepperFM\FilamentJson\Columns\JsonColumn;

class RawJsonStringTable extends BaseTable
{
    public function table(Table $table): Table
    {
        return parent::table($table)
            ->columns([
                JsonColumn::make('raw_payload')
                    ->inModal()
                    ->asTree()
                    ->state('{"raw":0,"flag":false,"nested":{"label":"kept"}}'),
            ]);
    }
}
