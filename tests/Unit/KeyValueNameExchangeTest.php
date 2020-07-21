<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Exceptions\DuplicateKeyException;
use Rexlabs\Enum\Exceptions\InvalidEnumException;
use Rexlabs\Enum\Exceptions\InvalidKeyException;
use Rexlabs\Enum\Exceptions\InvalidValueException;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\Beverage;
use Rexlabs\Enum\Tests\Stub\DuplicateKey;
use Rexlabs\Enum\Tests\Stub\Fruit;
use Rexlabs\Enum\Tests\Stub\Number;

class KeyValueNameExchangeTest extends TestCase
{
    public function test_can_get_value_for_key()
    {
        // Not mapped
        self::assertEquals(null, Number::valueForKey(Number::TWENTY_FOUR));

        // Mapped
        self::assertEquals('Kitty-cat', Animal::valueForKey(Animal::CAT));
        self::assertEquals(null, Animal::valueForKey(Animal::DOG));
        self::assertEquals(['you', 'filthy', 'animal'], Animal::valueForKey('skyrat'));
    }

    public function test_value_for_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Fruit::valueForKey('_does_not_exist_');
    }

    public function test_can_get_value_for_name()
    {
        self::assertEquals('Apple', Fruit::valueForName('APPLE'));
        self::assertEquals(null, Number::valueForName('TWENTY_FOUR'));
    }

    public function test_value_for_invalid_name_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        Fruit::valueForName('_does_not_exist_');
    }

    public function test_can_get_name_for_key()
    {
        self::assertEquals(Fruit::APPLE()->name(), Fruit::nameForKey(Fruit::APPLE));
    }

    public function test_get_name_for_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Fruit::nameForKey('_does_not_exist_');
    }

    public function test_get_name_for_duplicate_key_throws_exception()
    {
        $this->expectException(DuplicateKeyException::class);
        DuplicateKey::nameForKey(DuplicateKey::FIRST);
    }

    public function test_get_key_by_value()
    {
        self::assertEquals(Beverage::BREW, Beverage::keyForValue('Corona'));
        self::assertEquals(Beverage::RUM, Beverage::keyForValue('Bundaberg'));
    }

    public function test_get_key_by_invalid_value_throws_exception()
    {
        $this->expectException(InvalidValueException::class);
        self::assertEquals(Beverage::BREW, Beverage::keyForValue('Water'));
    }

    public function test_get_key_by_duplicate_value_returns_first()
    {
        // Fruit::EGGPLANT and Fruit::AUBERGINE are both mapped to 'Eggplant'
        self::assertEquals(Fruit::EGGPLANT, Fruit::keyForValue('Eggplant'));
    }
}
