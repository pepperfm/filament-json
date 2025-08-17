<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

use Pepperfm\Ssd\BaseDto;
use Filament\Support\Enums\Width;

class ModalConfigDto extends BaseDto
{
    public ?string $id = null;

    public string $icon = 'heroicon-m-sparkles';

    public string $iconColor = 'primary';

    public string $alignment = 'start';

    public string $width = Width::TwoExtraLarge->value;

    public bool $closeByClickingAway = true;

    public bool $closedByEscaping = true;

    public bool $closedButton = true;

    public bool $autofocus = true;
}
