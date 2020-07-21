<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;

/**
 * Class DuplicateKey
 *
 * @package Rexlabs\Enum\Tests\Stub
 *
 * @method static static FIRST()
 * @method static static SECOND()
 */
class DuplicateKey extends Enum
{
    const FIRST = 'duplicate';
    const SECOND = 'duplicate';
}