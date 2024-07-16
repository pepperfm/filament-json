<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PepperFM\FilamentJson\Tests\src\Models\User;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'properties' => [
                'ip' => '127.0.0.1',
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64)',
            ],
        ];
    }
}
