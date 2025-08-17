<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Concerns;

use PepperFM\FilamentJson\Enums\ContainerModeEnum;

trait HasContainerPresentation
{
    protected ContainerModeEnum $container = ContainerModeEnum::Drawer;

    public function presentIn(ContainerModeEnum $mode): static
    {
        $this->container = $mode;

        return $this;
    }

    public function inModal(bool $on = true): static
    {
        if ($on) {
            $this->presentIn(ContainerModeEnum::Modal);
        }

        return $this;
    }

    public function inDrawer(bool $on = true): static
    {
        if ($on) {
            $this->presentIn(ContainerModeEnum::Drawer);
        }

        return $this;
    }

    public function inlineContainer(bool $on = true): static
    {
        if ($on) {
            if (method_exists($this, 'inline')) {
                /** @phpstan-ignore-next-line */
                parent::inline(true);
            }
            $this->presentIn(ContainerModeEnum::Inline);
        }

        return $this;
    }

    public function getContainerMode(): ContainerModeEnum
    {
        if (method_exists($this, 'isInline') && $this->isInline()) {
            return ContainerModeEnum::Inline;
        }

        return $this->container;
    }

    public function isModalContainer(): bool
    {
        return $this->getContainerMode() === ContainerModeEnum::Modal;
    }

    public function isDrawerContainer(): bool
    {
        return $this->getContainerMode() === ContainerModeEnum::Drawer;
    }

    public function isInlineContainer(): bool
    {
        return $this->getContainerMode() === ContainerModeEnum::Inline;
    }

    /** ---------- Back-compat / deprecated API ---------- */

    /** @deprecated Use inModal() or presentIn(ContainerModeEnum::Modal) */
    public function asModal(bool $on = true): static
    {
        return $this->inModal($on);
    }

    /** @deprecated Use inDrawer() or presentIn(ContainerModeEnum::Drawer) */
    public function asDrawer(bool $on = true): static
    {
        return $this->inDrawer($on);
    }

    /**
     * @deprecated Prefer inlineContainer()
     *
     * @param bool|\Closure $condition
     */
    public function inline(bool|\Closure $condition = true): static
    {
        /** @phpstan-ignore-next-line */
        parent::inline($condition);

        if ($this->evaluate($condition)) {
            $this->presentIn(ContainerModeEnum::Inline);
        }

        return $this;
    }

    /** @deprecated Use isModalContainer() */
    public function getAsModal(): bool
    {
        return $this->isModalContainer();
    }

    /** @deprecated Use isDrawerContainer() */
    public function getAsDrawer(): bool
    {
        return $this->isDrawerContainer();
    }

    /** @deprecated Use getContainerMode() */
    public function getContainer(): ContainerModeEnum
    {
        return $this->getContainerMode();
    }
}
