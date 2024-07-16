<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Tests\src\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use PepperFM\FilamentJson\Tests\database\factories\UserFactory;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    protected static function newFactory(): UserFactory
    {
        return UserFactory::new();
    }
}
