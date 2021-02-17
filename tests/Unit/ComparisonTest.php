<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Exceptions\InvalidEnumException;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\Fruit;
use Rexlabs\Enum\Tests\Stub\Number;

class ComparisonTest extends TestCase
{
    public function test_can_compare_enums()
    {
        // No map
        self::assertTrue(Fruit::APPLE()->is(Fruit::APPLE()));
        self::assertTrue(Fruit::BANANA()->is(Fruit::BANANA()));
        self::assertFalse(Fruit::APPLE()->is(Fruit::BANANA()));

        // Mapped
        self::assertTrue(Animal::CAT()->is(Animal::CAT()));
        self::assertFalse(Animal::DOG()->is(Animal::HORSE()));
        self::assertFalse(Animal::CAT()->is(Animal::PIGEON()));

        // Mixed types
        self::assertFalse(Fruit::APPLE()->is(Animal::CAT()));

        // By constant key
        self::assertTrue(Fruit::APPLE()->is(Fruit::APPLE));
        self::assertFalse(Fruit::APPLE()->is(Fruit::BANANA));
        self::assertFalse(Fruit::APPLE()->is('_not_defined_'));

        // When key is not a string
        self::assertTrue(Number::TWENTY_FOUR()->is(24));
    }

    public function test_is_not_comparison()
    {
        self::assertFalse(Fruit::APPLE()->isNot(Fruit::APPLE()));
        self::assertTrue(Fruit::APPLE()->isNot(Fruit::BANANA()));
    }

    public function test_is_any_of_comparison()
    {
        self::assertTrue(Fruit::APPLE()->isAnyOf([Fruit::APPLE(), Fruit::BANANA()]));
        self::assertFalse(Fruit::APPLE()->isAnyOf([Fruit::BANANA(), Fruit::CHERRY(), Fruit::EGGPLANT()]));
    }

    public function test_is_none_of_comparison()
    {
        self::assertFalse(Fruit::APPLE()->isNoneOf([Fruit::APPLE(), Fruit::BANANA()]));
        self::assertTrue(Fruit::APPLE()->isNoneOf([Fruit::BANANA(), Fruit::CHERRY(), Fruit::EGGPLANT()]));
    }

    public function test_comparing_enum_to_an_invalid_argument_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        $this->expectExceptionMessage('Enum instance or key (scalar) expected but array given.');
        self::assertTrue(Fruit::APPLE()->is([]));
    }

    public function test_comparing_enum_to_an_invalid_object_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        $this->expectExceptionMessage('Enum instance or key (scalar) expected but stdClass instance given.');
        self::assertTrue(Fruit::APPLE()->is((object) []));
    }
}
