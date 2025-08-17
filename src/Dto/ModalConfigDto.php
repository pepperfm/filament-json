<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

use Pepperfm\Ssd\BaseDto;
use Filament\Support\Icons\Heroicon;
use Filament\Support\Enums\Alignment;
use Filament\Support\Enums\Width;

class ModalConfigDto extends BaseDto
{
    public ?string $id = null;

    public Heroicon $icon = Heroicon::Sparkles;

    public string $iconColor = 'primary';

    public Alignment $alignment = Alignment::Start;

    public Width $width = Width::TwoExtraLarge;

    public bool $closeByClickingAway = true;

    public bool $closedByEscaping = true;

    public bool $closedButton = true;

    public bool $autofocus = true;
}
