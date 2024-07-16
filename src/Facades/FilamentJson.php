<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \PepperFM\FilamentJson\FilamentJson
 */
class FilamentJson extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \PepperFM\FilamentJson\FilamentJson::class;
    }
}
