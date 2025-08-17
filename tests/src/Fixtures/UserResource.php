<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use PepperFM\FilamentJson\Columns\JsonColumn;
use PepperFM\FilamentJson\Tests\src\Models\User;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession(false)
            ->persistSortInSession(false)
            ->persistSearchInSession(false)
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('email'),
                JsonColumn::make('properties')->filterNullable(),
            ]);
    }
}
