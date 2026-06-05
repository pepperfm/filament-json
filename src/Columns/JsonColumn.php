<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Columns;

use Filament\Tables\Columns\Column;
use Illuminate\Contracts\Support\Arrayable;
use PepperFM\FilamentJson\Dto\ButtonConfigDto;
use PepperFM\FilamentJson\Dto\ModalConfigDto;
use PepperFM\FilamentJson\Concerns\HasRenderMode;
use PepperFM\FilamentJson\Concerns\HasContainerPresentation;

class JsonColumn extends Column
{
    use HasContainerPresentation, HasRenderMode;

    protected string $view = 'filament-json::json';

    /* Behavior */
    protected bool $filterNullable = true;

    protected int $maxDepth = 3;

    protected ?int $characterLimit = null;

    /* Labels (table mode) */
    protected string $keyColumnLabel = 'Key';

    protected string $valueColumnLabel = 'Value';

    /* UX toggles */
    protected int $initiallyCollapsed = 1;

    protected bool $expandAllToggle = false;

    protected bool $copyJsonAction = true;

    /* Config DTOs */
    protected ButtonConfigDto $buttonConfig;

    protected ModalConfigDto $modalConfig;

    public static function make(?string $name = null): static
    {
        $columnClass = self::class;

        $name ??= self::getDefaultName();

        if (blank($name)) {
            throw new \InvalidArgumentException("Column of class [$columnClass] must have a unique name, passed to make().");
        }

        /** @var static $static */
        $static = app($columnClass, ['name' => $name]);
        $static->configure();

        $static->buttonConfig = ButtonConfigDto::make();
        $static->modalConfig = ModalConfigDto::make();

        return $static;
    }

    /* UX / behavior */

    public function initiallyCollapsed(int $depth = 1): static
    {
        $this->initiallyCollapsed = max(0, $depth);

        return $this;
    }

    public function getInitiallyCollapsed(): int
    {
        return $this->initiallyCollapsed;
    }

    public function expandAllToggle(bool $show = true): static
    {
        $this->expandAllToggle = $show;

        return $this;
    }

    public function getExpandAllToggle(): bool
    {
        return $this->expandAllToggle;
    }

    public function copyJsonAction(bool $show = true): static
    {
        $this->copyJsonAction = $show;

        return $this;
    }

    public function getCopyJsonAction(): bool
    {
        return $this->copyJsonAction;
    }

    public function maxDepth(int $depth): static
    {
        $this->maxDepth = max(1, $depth);

        return $this;
    }

    public function getMaxDepth(): int
    {
        return $this->maxDepth;
    }

    public function filterNullable(?bool $value = true): static
    {
        $this->filterNullable = (bool) $value;

        return $this;
    }

    public function getFilterNullable(): bool
    {
        return $this->filterNullable;
    }

    public function characterLimit(?int $limit): static
    {
        $this->characterLimit = $limit;

        return $this;
    }

    public function getCharacterLimit(): ?int
    {
        return $this->characterLimit;
    }

    /* Labels (table mode) */

    public function keyColumnLabel(string $label = 'Key'): static
    {
        $this->keyColumnLabel = $label;

        return $this;
    }

    public function getKeyColumnLabel(): string
    {
        return $this->keyColumnLabel;
    }

    public function valueColumnLabel(string $label = 'Value'): self
    {
        $this->valueColumnLabel = $label;

        return $this;
    }

    public function getValueColumnLabel(): string
    {
        return $this->valueColumnLabel;
    }

    /* Config DTOs */

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

    /* Runtime helpers */

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function applyLimit(mixed $value): mixed
    {
        if (is_string($value) && $this->characterLimit) {
            return str($value)->limit($this->characterLimit)->value();
        }
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return $value ?? 'null';
    }

    public function getState(): mixed
    {
        return $this->normalizeState(parent::getState());
    }

    public function getJsonForCopy(): string
    {
        $state = parent::getState();

        if (is_string($state)) {
            try {
                return $this->encodeJson($this->normalizeState(
                    json_decode($state, associative: true, flags: JSON_THROW_ON_ERROR)
                ));
            } catch (\JsonException) {
                return $state;
            }
        }

        return $this->encodeJson($this->normalizeState($state));
    }

    protected function normalizeState(mixed $state): mixed
    {
        if (is_string($state)) {
            $state = $this->decodeJsonString($state);
        }
        if ($state instanceof Arrayable) {
            $state = $state->toArray();
        }
        if (!is_array($state)) {
            return $state;
        }

        $normalized = [];

        foreach ($state as $key => $value) {
            if ($this->filterNullable && $value === null) {
                continue;
            }

            $normalized[$key] = $this->normalizeState($value);
        }

        return $normalized;
    }

    protected function decodeJsonString(string $state): mixed
    {
        try {
            return json_decode($state, associative: true, flags: JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return $state;
        }
    }

    protected function encodeJson(mixed $state): string
    {
        $encoded = json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        return $encoded === false ? '' : $encoded;
    }
}
