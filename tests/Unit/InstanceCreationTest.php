<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Exceptions\InvalidEnumException;
use Rexlabs\Enum\Exceptions\InvalidKeyException;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\Beverage;
use Rexlabs\Enum\Tests\Stub\Fruit;

class InstanceCreationTest extends TestCase
{
    public function test_can_instantiate_instance()
    {
        $fruit = Fruit::BANANA();
        self::assertInstanceOf(Fruit::class, $fruit);

        $animal = Animal::CAT();
        self::assertInstanceOf(Animal::class, $animal);
    }

    public function test_that_getting_an_instance_from_an_invalid_name_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);

        /** @noinspection PhpUndefinedMethodInspection */
        Fruit::NON_EXISTENT();
    }

    public function test_get_instance_via_name()
    {
        $fruit = Fruit::instanceFromName('BANANA');
        self::assertInstanceOf(Fruit::class, $fruit);

        $animal = Animal::instanceFromName('CAT');
        self::assertInstanceOf(Animal::class, $animal);

        $beverage = Beverage::instanceFromName('BREW');
        self::assertInstanceOf(Beverage::class, $beverage);

        $this->expectException(InvalidEnumException::class);
        Animal::instanceFromName('cat'); // Case sensitive
    }

    public function test_get_instance_via_key()
    {
        $animal = Animal::instanceFromKey('kitty');
        self::assertTrue($animal->is(Animal::CAT()));

        $beverage = Beverage::instanceFromKey(0);
        self::assertTrue($beverage->is(Beverage::BREW));
        self::assertFalse($beverage->is(Beverage::RED_WINE));
    }

    public function test_get_instance_via_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Animal::instanceFromKey('_invalid_key_');
    }

    public function test_instantiate_with_invalid_name_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);

        /** @noinspection PhpUndefinedMethodInspection */
        Animal::INVALID_KEY();
    }
}
