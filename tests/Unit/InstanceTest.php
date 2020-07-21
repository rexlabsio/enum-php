<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\Fruit;
use Rexlabs\Enum\Tests\Stub\Number;

class InstanceTest extends TestCase
{
    public function test_can_get_name_from_instance()
    {
        self::assertEquals('APPLE', Fruit::APPLE()->name());
        self::assertEquals('DOG', Animal::DOG()->name());
    }

    public function test_can_get_key_from_instance()
    {
        self::assertEquals('apple', Fruit::APPLE()->key());
        self::assertEquals('dog', Animal::DOG()->key());
    }

    public function test_can_get_key_from_instance_with_int_keys()
    {
        self::assertEquals(10, Number::TEN()->key());
        self::assertEquals(24, Number::TWENTY_FOUR()->key());
    }

    public function test_can_get_value_from_instance()
    {
        self::assertEquals('Apple', Fruit::APPLE()->value());
        self::assertEquals(null, Number::TWENTY_FOUR()->value());
        self::assertEquals('Kitty-cat', Animal::CAT()->value());
        self::assertEquals(null, Animal::HORSE()->value());
        self::assertEquals(['you', 'filthy', 'animal'], Animal::PIGEON()->value());
    }

    public function test_casting_enum_to_string_returns_name()
    {
        // TODO feels like this behaviour should be changed to cast to the "key"
        // would be a breaking change as enums often cast to string and save as
        // the "name" in the database.
        self::assertEquals(Fruit::APPLE()->name(), (string)Fruit::APPLE());
    }
}