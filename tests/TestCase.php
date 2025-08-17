<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests;

use BladeUI\Heroicons\BladeHeroiconsServiceProvider;
use BladeUI\Icons\BladeIconsServiceProvider;
use Filament\Actions\ActionsServiceProvider;
use Filament\Facades\Filament;
use Filament\FilamentServiceProvider;
use Filament\Forms\FormsServiceProvider;
use Filament\Infolists\InfolistsServiceProvider;
use Filament\Notifications\NotificationsServiceProvider;
use Filament\Panel;
use Filament\PanelRegistry;
use Filament\Support\SupportServiceProvider;
use Filament\Tables\TablesServiceProvider;
use Filament\Widgets\WidgetsServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use RyanChandler\BladeCaptureDirective\BladeCaptureDirectiveServiceProvider;
use PepperFM\FilamentJson\FilamentJsonServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            static fn(string $modelName) => 'PepperFM\FilamentJson\Database\Factories\\' . class_basename($modelName) . 'Factory'
        );

        $panel = Panel::make()
            ->default()
            ->id('tests')
            ->path('tests')
            ->resources([\PepperFM\FilamentJson\Tests\src\Fixtures\UserResource::class]);

        app(PanelRegistry::class)->register($panel);
        Filament::setCurrentPanel($panel);
    }

    protected function getPackageProviders($app): array
    {
        return [
            ActionsServiceProvider::class,
            BladeCaptureDirectiveServiceProvider::class,
            BladeHeroiconsServiceProvider::class,
            BladeIconsServiceProvider::class,
            FilamentServiceProvider::class,
            FormsServiceProvider::class,
            InfolistsServiceProvider::class,
            LivewireServiceProvider::class,
            NotificationsServiceProvider::class,
            SupportServiceProvider::class,
            TablesServiceProvider::class,
            WidgetsServiceProvider::class,
            FilamentJsonServiceProvider::class,

            \PepperFM\FilamentJson\Tests\src\Fixtures\TestPanelProvider::class,
        ];
    }

    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    public function getEnvironmentSetUp($app): void
    {
        // $app['config']->set('session.driver', 'array');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
        $app['config']->set(
            'view.paths',
            array_merge(
                $app['config']->get('view.paths'),
                [__DIR__ . '/resources/views']
            )
        );
    }
}
