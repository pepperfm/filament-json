<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

use Pepperfm\Ssd\BaseDto;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class ButtonConfigDto extends BaseDto
{
    public string $color = 'primary';

    public Heroicon $icon = Heroicon::OutlinedSwatch;

    public ?string $label = null;

    public ?string $tooltip = null;

    public Width $size = Width::Medium;

    public ?string $href = null;

    public ?string $tag = null;
}
