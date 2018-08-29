<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;
use Rexlabs\Enum\Traits\Flipable;

class Bevs extends Enum
{
    use Flipable;

    const BREW = 0;
    const RED_WINE = 1;
    const WHITE_WINE = 2;
    const RUM = 3;
    const BOURBON = 4;

    public static function map(): array
    {
        return [
            self::BREW => 'Corona',
            self::RED_WINE => 'Red Wine',
            self::WHITE_WINE => 'White Wine',
            self::RUM => 'Bundaberg',
            self::BOURBON => 'Jack Daniels',
        ];
    }
}
