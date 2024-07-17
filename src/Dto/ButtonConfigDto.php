<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

class ButtonConfigDto extends BaseDto
{
    public string $color = 'primary';

    public string $icon = 'heroicon-m-sparkles';

    public ?string $label = null;

    public ?string $tooltip = null;

    public string $size = 'md';

    public ?string $href = null;

    public ?string $tag = null;
}
