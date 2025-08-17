<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Enums;

enum ContainerModeEnum: string
{
    case Inline = 'inline';
    case Modal = 'modal';
    case Drawer = 'drawer';
}
