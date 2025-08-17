<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

use Filament\Panel;
use Filament\PanelProvider;
class TestPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('tests')
            ->path('tests')
            ->resources([
                \PepperFM\FilamentJson\Tests\src\Fixtures\UserResource::class,
            ]);
    }
}
