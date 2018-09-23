<?php

namespace Rexlabs\Enum\Tests\Stub;

use Rexlabs\Enum\Enum;

class DuplicateKey extends Enum
{
    const FIRST = 'duplicate';
    const SECOND = 'duplicate';
}