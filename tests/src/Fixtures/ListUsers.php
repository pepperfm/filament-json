<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

class ListUsers extends \Filament\Resources\Pages\ListRecords
{
    protected static string $resource = UserResource::class;
}
