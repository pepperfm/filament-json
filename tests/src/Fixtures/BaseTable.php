<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Fixtures;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\MessageBag;
use Livewire\Component;
use PepperFM\FilamentJson\Tests\src\Models\User;

class BaseTable extends Component implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions, InteractsWithSchemas, InteractsWithTable;

    protected ?MessageBag $errorBag = null;

    // переводы не нужны в тестах
    public function makeFilamentTranslatableContentDriver(): ?TranslatableContentDriver
    {
        return null;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query($this->getTableQuery())
            ->columns([]);
    }

    protected function getTableQuery(): Builder
    {
        return User::query();
    }

    protected function shouldPersistTableFiltersInSession(): bool
    {
        return false;
    }

    public function render(): View
    {
        return view('columns.fixtures.table');
    }

    public function getErrorBag(): MessageBag
    {
        return $this->errorBag ??= new MessageBag();
    }

    public function setErrorBag($bag)
    {
        $this->errorBag = $bag instanceof MessageBag ? $bag : new MessageBag($bag);
    }
}
