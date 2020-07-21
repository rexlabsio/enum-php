<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Tests\Stub\Fruit;

class ValidationTest extends TestCase
{
    public function test_can_test_name_exists()
    {
        self::assertTrue(Fruit::isValidName('APPLE'));
        self::assertFalse(Fruit::isValidName('_does_not_exist_'));
    }

    public function test_can_test_key_exists()
    {
        self::assertTrue(Fruit::isValidKey(Fruit::APPLE));
        self::assertFalse(Fruit::isValidKey('_does_not_exist_'));
    }
}
