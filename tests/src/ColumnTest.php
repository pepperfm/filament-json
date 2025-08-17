<?php

declare(strict_types=1);

use PepperFM\FilamentJson\Tests\src\Models\User;

use function Pest\Livewire\livewire;

test('can render column', function (): void {
    $user = User::factory()->make();

    livewire(\PepperFM\FilamentJson\Tests\src\Fixtures\ListUsers::class)
        ->assertSuccessful()
        ->assertCanRenderTableColumn('properties')
        ->assertTableColumnExists('properties')
        ->assertTableColumnStateSet('properties', $user->properties, $user);
})->skip();
