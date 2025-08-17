<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Concerns;

use PepperFM\FilamentJson\Enums\RenderModeEnum;

trait HasRenderMode
{
    protected RenderModeEnum $renderMode = RenderModeEnum::Tree;

    public function renderAs(RenderModeEnum $mode): static
    {
        $this->renderMode = $mode;

        return $this;
    }

    public function asTree(bool $on = true): static
    {
        if ($on) {
            $this->renderAs(RenderModeEnum::Tree);
        }

        return $this;
    }

    public function asTable(bool $on = true): static
    {
        if ($on) {
            $this->renderAs(RenderModeEnum::Table);
        }

        return $this;
    }

    public function getRenderMode(): RenderModeEnum
    {
        return $this->renderMode;
    }

    public function isTree(): bool
    {
        return $this->renderMode === RenderModeEnum::Tree;
    }

    public function isTable(): bool
    {
        return $this->renderMode === RenderModeEnum::Table;
    }
}
