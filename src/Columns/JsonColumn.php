<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Columns;

use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;

class JsonColumn extends TextColumn
{
    protected string $view = 'filament-json::json';

    protected bool|\Closure $isHtml = true;

    protected bool $asModal = false;

    protected bool $asDrawer = false;

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

    public function getAsModal(): bool
    {
        return $this->evaluate($this->asModal);
    }

    public function getAsDrawer(): bool
    {
        return $this->evaluate($this->asDrawer);
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
