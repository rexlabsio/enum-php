<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Exceptions\DuplicateKeyException;
use Rexlabs\Enum\Exceptions\InvalidEnumException;
use Rexlabs\Enum\Exceptions\InvalidKeyException;
use Rexlabs\Enum\Exceptions\InvalidValueException;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\DuplicateKey;
use Rexlabs\Enum\Tests\Stub\Fruit;
use Rexlabs\Enum\Tests\Stub\Beverage;
use Rexlabs\Enum\Tests\Stub\Number;

class EnumTest extends TestCase
{
    public function test_can_get_names()
    {
        $this->assertEquals([
            'APPLE',
            'BANANA',
            'CHERRY',
            'EGGPLANT',
            'AUBERGINE',
        ], Fruit::names());

        $this->assertEquals([
            'CAT',
            'DOG',
            'HORSE',
            'PIGEON',
        ], Animal::names());
    }

    public function test_can_get_keys()
    {
        $this->assertEquals([
            Fruit::APPLE,
            Fruit::BANANA,
            Fruit::CHERRY,
            Fruit::EGGPLANT,
            Fruit::AUBERGINE,
        ], Fruit::keys());

        $this->assertEquals([
            Animal::CAT,
            Animal::DOG,
            Animal::HORSE,
            Animal::PIGEON,
        ], Animal::keys());
    }

    public function test_can_test_name_exists()
    {
        $this->assertTrue(Fruit::isValidName('APPLE'));
        $this->assertFalse(Fruit::isValidName('_does_not_exist_'));
    }


    public function test_get_values()
    {
        // Number does not provide a map() method and therefore all keys are
        // by default mapped to a value of null
        $this->assertEquals([
            null,
            null,
            null,
            null,
        ], Number::values());

        // When map() is defined, should return all of the mapped values
        $this->assertEquals([
            'Kitty-cat',
            null,
            null,
            ['you', 'filthy', 'animal'],
        ], Animal::values());
    }

    public function test_can_get_value_for_key()
    {
        // Not mapped
        $this->assertEquals(null, Number::valueForKey(Number::TWENTY_FOUR));

        // Mapped
        $this->assertEquals('Kitty-cat', Animal::valueForKey(Animal::CAT));
        $this->assertEquals(null, Animal::valueForKey(Animal::DOG));
        $this->assertEquals(['you', 'filthy', 'animal'], Animal::valueForKey('skyrat'));
    }

    public function test_value_for_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Fruit::valueForKey('_does_not_exist_');
    }

    public function test_can_get_value_for_name()
    {
        $this->assertEquals('Apple', Fruit::valueForName('APPLE'));
        $this->assertEquals(null, Number::valueForName('TWENTY_FOUR'));
    }

    public function test_value_for_invalid_name_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        Fruit::valueForName('_does_not_exist_');
    }

    public function test_can_get_name_for_key()
    {
        $this->assertEquals(Fruit::APPLE()->name(), Fruit::nameForKey(Fruit::APPLE));
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

    public function test_can_instantiate_instance()
    {
        $fruit = Fruit::BANANA();
        $this->assertInstanceOf(Fruit::class, $fruit);

        $animal = Animal::CAT();
        $this->assertInstanceOf(Animal::class, $animal);
    }

    public function test_can_get_name_from_instance()
    {
        $this->assertEquals('APPLE', Fruit::APPLE()->name());
        $this->assertEquals('DOG', Animal::DOG()->name());
    }

    public function test_can_get_key_from_instance()
    {
        $this->assertEquals('apple', Fruit::APPLE()->key());
        $this->assertEquals('dog', Animal::DOG()->key());
    }

    public function test_can_get_key_from_instance_with_int_keys()
    {
        $this->assertEquals(10, Number::TEN()->key());
        $this->assertEquals(24, Number::TWENTY_FOUR()->key());
    }

    public function test_can_get_value_from_instance()
    {
        $this->assertEquals('Apple', Fruit::APPLE()->value());
        $this->assertEquals(null, Number::TWENTY_FOUR()->value());
        $this->assertEquals('Kitty-cat', Animal::CAT()->value());
        $this->assertEquals(null, Animal::HORSE()->value());
        $this->assertEquals(['you', 'filthy', 'animal'], Animal::PIGEON()->value());
    }

    public function test_can_compare_enums()
    {
        // No map
        $this->assertTrue(Fruit::APPLE()->is(Fruit::APPLE()));
        $this->assertTrue(Fruit::BANANA()->is(Fruit::BANANA()));
        $this->assertFalse(Fruit::APPLE()->is(Fruit::BANANA()));

        // Mapped
        $this->assertTrue(Animal::CAT()->is(Animal::CAT()));
        $this->assertFalse(Animal::DOG()->is(Animal::HORSE()));
        $this->assertFalse(Animal::CAT()->is(Animal::PIGEON()));

        // Mixed types
        $this->assertFalse(Fruit::APPLE()->is(Animal::CAT()));

        // By constant key
        $this->assertTrue(Fruit::APPLE()->is(Fruit::APPLE));
        $this->assertFalse(Fruit::APPLE()->is(Fruit::BANANA));
        $this->assertFalse(Fruit::APPLE()->is('_not_defined_'));

        // When key is not a string
        $this->assertTrue(Number::TWENTY_FOUR()->is(24));
    }

    public function test_comparing_enum_to_an_invalid_argument_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        $this->expectExceptionMessage('Enum instance or key (scalar) expected but array given.');
        $this->assertTrue(Fruit::APPLE()->is([]));
    }

    public function test_comparing_enum_to_an_invalid_object_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        $this->expectExceptionMessage('Enum instance or key (scalar) expected but stdClass instance given.');
        $this->assertTrue(Fruit::APPLE()->is((object) []));
    }

    public function test_that_getting_an_instance_from_an_invalid_name_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        Fruit::NON_EXISTENT();
    }

    public function test_casting_enum_to_string_returns_name()
    {
        $this->assertEquals(Fruit::APPLE()->name(), (string)Fruit::APPLE());
    }

    public function test_get_key_by_value()
    {
        $this->assertEquals(Beverage::BREW, Beverage::keyForValue('Corona'));
        $this->assertEquals(Beverage::RUM, Beverage::keyForValue('Bundaberg'));
    }

    public function test_get_key_by_invalid_value_throws_exception()
    {
        $this->expectException(InvalidValueException::class);
        $this->assertEquals(Beverage::BREW, Beverage::keyForValue('Water'));
    }

    public function test_get_key_by_duplicate_value_returns_first()
    {
        // Fruit::EGGPLANT and Fruit::AUBERGINE are both mapped to 'Eggplant'
        $this->assertEquals(Fruit::EGGPLANT, Fruit::keyForValue('Eggplant'));
    }

    public function test_get_instance_via_name()
    {
        $fruit = Fruit::instanceFromName('BANANA');
        $this->assertInstanceOf(Fruit::class, $fruit);

        $animal = Animal::instanceFromName('CAT');
        $this->assertInstanceOf(Animal::class, $animal);

        $beverage = Beverage::instanceFromName('BREW');
        $this->assertInstanceOf(Beverage::class, $beverage);

        $this->expectException(InvalidEnumException::class);
        Animal::instanceFromName('cat'); // Case sensitive
    }

    public function test_get_instance_via_key()
    {
        $animal = Animal::instanceFromKey('kitty');
        $this->assertTrue($animal->is(Animal::CAT()));

        $beverage = Beverage::instanceFromKey(0);
        $this->assertTrue($beverage->is(Beverage::BREW));
        $this->assertFalse($beverage->is(Beverage::RED_WINE));
    }

    public function test_get_instance_via_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Animal::instanceFromKey('_invalid_key_');
    }

    public function test_instantiate_with_invalid_name_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        Animal::INVALID_KEY();
    }
}
