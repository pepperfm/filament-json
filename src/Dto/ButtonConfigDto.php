<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

use Pepperfm\Ssd\BaseDto;

class ButtonConfigDto extends BaseDto
{
    public string $color = 'primary';

    public string $icon = 'heroicon-o-swatch';

    public ?string $label = null;

    public ?string $tooltip = null;

    public string $size = 'md';

    public ?string $href = null;

    public ?string $tag = null;
}
