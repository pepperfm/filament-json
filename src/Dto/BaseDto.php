<?php

declare(strict_types=1);

namespace PepperFM\FilamentJson\Dto;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

abstract class BaseDto implements Arrayable
{
    /**
     * @param array|\Illuminate\Contracts\Support\Arrayable|\stdClass $params
     */
    public function __construct(array|Arrayable|\stdClass $params = [])
    {
        if ($params instanceof Arrayable) {
            $params = $params->toArray();
        }
        foreach ((array) $params as $key => $param) {
            $camelKey = str($key)->camel()->value();
            if (property_exists($this, $camelKey)) {
                $this->$camelKey = $param;
            }
        }
    }

    public function __get(string $name)
    {
        $camelKey = str($name)->camel()->value();

        return $this->$camelKey;
    }

    public static function make(): static
    {
        /* @phpstan-ignore-next-line */
        return new static(...func_get_args());
    }

    // public function __set(string $name, $value): void
    // {
    //     $this->$name = $value;
    // }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [];
        foreach ((array) $this as $key => $item) {
            $snakeKey = str($key)->snake()->replaceMatches('/([^\d])(\d++)/', '\1_\2')->value();
            $array[$snakeKey] = $item;
        }

        return $array;
    }

    final public function except(...$keys): array
    {
        return Arr::except($this->toArray(), ...$keys);
    }

    final public function only(...$keys): array
    {
        return Arr::only($this->toArray(), ...$keys);
    }
}
