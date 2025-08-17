<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use PepperFM\FilamentJson\Dto\{ButtonConfigDto, ModalConfigDto};

class JsonColumn extends TextColumn
{
    protected string $view = 'filament-json::json';

    protected bool|\Closure $isHtml = true;

    protected bool $asModal = false;

    protected bool $asDrawer = true;

    protected bool $filterNullable = true;

    protected string $keyColumnLabel = 'Key';

    protected string $valueColumnLabel = 'Value';

    protected ButtonConfigDto $buttonConfig;

    protected ModalConfigDto $modalConfig;

    public static function make(?string $name = null): static
    {
        $columnClass = static::class;

        $name ??= static::getDefaultName();

        if (blank($name)) {
            throw new \Exception("Column of class [$columnClass] must have a unique name, passed to the [make()] method.");
        }

        $static = app($columnClass, ['name' => $name]);
        $static->configure();

        $static->buttonConfig = ButtonConfigDto::make();
        $static->modalConfig = ModalConfigDto::make();

        return $static;
    }

    public function applyLimit(null|array|string $value): null|array|\Illuminate\Support\Stringable|string
    {
        if (is_string($value)) {
            $characterLimit = $this->getCharacterLimit();

            return $characterLimit ? str($value)->limit($characterLimit) : $value;
        }

        return $value;
    }

    public function asModal(bool $condition = true): static
    {
        $this->asDrawer = false;
        $this->asModal = $condition;

        return $this;
    }

    public function asDrawer(bool $condition = true): static
    {
        $this->asModal = false;
        $this->asDrawer = $condition;

        return $this;
    }

    public function button(array|Arrayable|\stdClass $config): static
    {
        $this->buttonConfig = ButtonConfigDto::make($config);

        return $this;
    }

    public function getButtonConfig(): ButtonConfigDto
    {
        return $this->buttonConfig;
    }

    public function modal(array|Arrayable|\stdClass $config): static
    {
        $this->modalConfig = ModalConfigDto::make($config);

        return $this;
    }

    public function keyColumnLabel(string $label = 'Key'): static
    {
        $this->keyColumnLabel = $label;

        return $this;
    }

    public function getKeyColumnLabel(): string
    {
        return $this->keyColumnLabel;
    }

    public function valueColumnLabel(string $label = 'Value'): static
    {
        $this->valueColumnLabel = $label;

        return $this;
    }

    public function getValueColumnLabel(): string
    {
        return $this->valueColumnLabel;
    }

    public function filterNullable(?bool $value = true): static
    {
        $this->filterNullable = $value;

        return $this;
    }

    public function getModalConfig(): ModalConfigDto
    {
        return $this->modalConfig;
    }

    public function getAsModal(): bool
    {
        return $this->asModal;
    }

    public function getAsDrawer(): bool
    {
        return $this->asDrawer;
    }

    public function getFilterNullable(): bool
    {
        return $this->filterNullable;
    }

    public function getState(): mixed
    {
        if (!$this->getRecord()) {
            return null;
        }
        $listLimit = $this->getListLimit();
        $state = ($this->getStateUsing !== null) ?
            $this->evaluate($this->getStateUsing) :
            $this->getStateFromRecord();

        if (is_string($state) && ($separator = $this->getSeparator())) {
            $state = explode($separator, $state);
            $state = (count($state) === 1 && blank($state[0])) ?
                [] :
                $state;
        }
        if (blank($state)) {
            $state = $this->getDefaultState();
        }
        if ($state instanceof Collection) {
            $state = $state->when(
                value: $this->getFilterNullable(),
                callback: static fn($collection) => $collection->filter()
            )->take($listLimit);
        }
        if (is_array($state)) {
            $state = collect($state)->when(
                value: $this->getFilterNullable(),
                callback: static fn($collection) => $collection->filter()
            )->take($listLimit);
        }

        return $state;
    }
}
