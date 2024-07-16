<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Commands;

use Illuminate\Console\Command;

class FilamentJsonCommand extends Command
{
    public $signature = 'filament-json';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
