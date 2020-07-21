<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;

/**
 * Class Fruit
 *
 * @package Rexlabs\Enum\Tests\Stub
 *
 * @method static static APPLE()
 * @method static static BANANA()
 * @method static static CHERRY()
 * @method static static EGGPLANT()
 * @method static static AUBERGINE()
 */
class Fruit extends Enum
{
    const APPLE = 'apple';
    const BANANA = 'banana';
    const CHERRY = 'cherry';
    const EGGPLANT = 'eggplant';
    const AUBERGINE = 'aubergine';

    public static function map(): array
    {
        return [
            static::APPLE => 'Apple',
            static::BANANA => 'Banana',
            static::CHERRY => 'Cherry',
            static::EGGPLANT => 'Eggplant',
            static::AUBERGINE => 'Eggplant',
        ];
    }
}