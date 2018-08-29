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
        return array_flip(static::map());
    }

    /**
     * Returns the constant for a given value
     *
     * @param [type] $value
     * @return Mixed
     */
    public static function constantOf($value)
    {
        $flipped = static::flip();
        if ( ! array_key_exists($value, $flipped)) {
            throw new InvalidValueException("Value '{$value}' not found in map for " . static::class);
        }

        return $flipped[$value];
    }
}
