<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;

/**
 * Class Beverage
 *
 * @package Rexlabs\Enum\Tests\Stub
 *
 * @method static static BREW()
 * @method static static RED_WINE()
 * @method static static WHITE_WINE()
 * @method static static RUM()
 * @method static static BOURBON()
 * @method static static SCOTCH()
 */
class Beverage extends Enum
{
    const BREW = 0;
    const RED_WINE = 1;
    const WHITE_WINE = 2;
    const RUM = 3;
    const BOURBON = 4;
    const SCOTCH = 5;

    public static function map(): array
    {
        return [
            self::BREW => 'Corona',
            self::RED_WINE => 'Red Wine',
            self::WHITE_WINE => 'White Wine',
            self::RUM => 'Bundaberg',
            self::BOURBON => 'Jack Daniels',
            self::SCOTCH => 'Lagavulin',
        ];
    }
}
