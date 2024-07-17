<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Columns;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use PepperFM\FilamentJson\Dto\{ButtonConfigDto, ModalConfigDto};

class JsonColumn extends TextColumn
{
    protected string $view = 'filament-json::json';

    protected bool|\Closure $isHtml = true;

    protected bool $asModal = false;

    protected bool $asDrawer = false;

    protected ButtonConfigDto $buttonConfig;

    protected ModalConfigDto $modalConfig;

    /**
     * @throws \Exception
     */
    public function getTable(): Table
    {
        $this->buttonConfig = ButtonConfigDto::make();
        $this->modalConfig = ModalConfigDto::make();

        return parent::getTable();
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
        $this->asModal = $condition;

        return $this;
    }

    public function asDrawer(bool $condition = true): static
    {
        $this->asModal = $condition;
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
            $state = $state->filter()->take($listLimit);
        }
        if (is_array($state)) {
            $state = collect($state)->filter()->take($listLimit);
        }

        return $state;
    }
}
