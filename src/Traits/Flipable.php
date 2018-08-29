<?php

namespace Rexlabs\Enum\Traits;

use Rexlabs\Enum\Exceptions\InvalidValueException;

trait Flipable
{
    /**
     * Return flipped map where keys become values and vice versa
     *
     * @return array
     */
    public static function flip(): array
    {
        return array_flip(static::cachedMap());
    }

    /**
     * Returns the constant for a given value
     *
     * @param [type] $value
     * @return array
     */
    public static function constantOf($value): array
    {
        if (! in_array($value, static::cachedMap())) {
            throw new InvalidValueException("Value '{$value}' not found in map for " . static::class);
        }
        return static::flip()[$value];
    }
}
