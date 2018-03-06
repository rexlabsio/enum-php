<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;

class Animal extends Enum
{
    const CAT = 'kitty';
    const DOG = 'dog';
    const HORSE = 'horse';
    const PIGEON = 'skyrat';

    public static function map(): array
    {
        return [
            self::CAT => 'Kitty-cat',
            self::DOG => null,
            self::HORSE => null,
            self::PIGEON => ['you','filthy','animal'],
        ];
    }
}