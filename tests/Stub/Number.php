<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;

/**
 * Class Number
 *
 * @package Rexlabs\Enum\Tests\Stub
 *
 * @method static static ONE()
 * @method static static EIGHT()
 * @method static static TEN()
 * @method static static TWENTY_FOUR()
 */
class Number extends Enum
{
    const ONE = 1;
    const EIGHT = 8;
    const TEN = 10;
    const TWENTY_FOUR = 24;
}