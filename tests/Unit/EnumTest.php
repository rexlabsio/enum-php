<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Enum;
use Rexlabs\Enum\Exceptions\InvalidEnumException;
use Rexlabs\Enum\Exceptions\InvalidKeyException;
use Rexlabs\Enum\Exceptions\InvalidValueException;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\Fruit;
use Rexlabs\Enum\Tests\Stub\Bevs;

class EnumTest extends TestCase
{
    public function test_can_get_identifiers()
    {
        $this->assertEquals([
            'APPLE',
            'BANANA',
            'CHERRY',
        ], Fruit::identifiers());

        $this->assertEquals([
            'CAT',
            'DOG',
            'HORSE',
            'PIGEON',
        ], Animal::identifiers());
    }

    public function test_can_get_keys()
    {
        $this->assertEquals([
            Fruit::APPLE,
            Fruit::BANANA,
            Fruit::CHERRY,
        ], Fruit::keys());

        $this->assertEquals([
            Animal::CAT,
            Animal::DOG,
            Animal::HORSE,
            Animal::PIGEON,
        ], Animal::keys());
    }

    public function test_can_test_identifier_exists()
    {
        $this->assertTrue(Fruit::identifierExists('APPLE'));
        $this->assertFalse(Fruit::identifierExists('_does_not_exist_'));
    }


    public function test_get_values()
    {
        // When map() is not defined, should return an array of null
        $this->assertEquals([
            null,
            null,
            null,
        ], Fruit::values());

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
        $this->assertEquals(null, Fruit::valueFor(Fruit::APPLE));

        // Mapped
        $this->assertEquals('Kitty-cat', Animal::valueFor(Animal::CAT));
        $this->assertEquals(null, Animal::valueFor(Animal::DOG));
        $this->assertEquals(['you', 'filthy', 'animal'], Animal::valueFor('skyrat'));
    }

    public function test_value_for_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Fruit::valueFor('_does_not_exist_');
    }

    public function test_can_instantiate_instance()
    {
        $fruit = Fruit::BANANA();
        $this->assertInstanceOf(Fruit::class, $fruit);

        $animal = Animal::CAT();
        $this->assertInstanceOf(Animal::class, $animal);
    }

    public function test_can_get_identifier_from_instance()
    {
        $this->assertEquals('APPLE', Fruit::APPLE()->identifier());
        $this->assertEquals('DOG', Animal::DOG()->identifier());
    }

    public function test_can_get_key_from_instance()
    {
        $this->assertEquals('apple', Fruit::APPLE()->key());
        $this->assertEquals('dog', Animal::DOG()->key());
    }

    public function test_can_get_value_from_instance()
    {
        $this->assertEquals(null, Fruit::APPLE()->value());
        $this->assertEquals(null, Fruit::BANANA()->value());

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
    }

    public function test_comparing_enum_to_an_invalid_argument_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        $this->assertTrue(Fruit::APPLE()->is([]));
    }

    public function test_that_getting_an_instance_from_an_invalid_identifier_throws_exception()
    {
        $this->expectException(InvalidEnumException::class);
        Fruit::NON_EXISTENT();
    }

    public function test_casting_enum_to_string_returns_identifier()
    {
        $this->assertEquals(Fruit::APPLE()->identifier(), (string)Fruit::APPLE());
    }

    public function test_flipable_trait_flips_map()
    {
        $this->assertEquals([
            'Corona' => Bevs::BREW,
            'Red Wine' => Bevs::RED_WINE,
            'White Wine' => Bevs::WHITE_WINE,
            'Bundaberg' => Bevs::RUM,
            'Jack Daniels' => Bevs::BOURBON,
        ], Bevs::flip());
    }

    public function test_flipable_trait_gets_constant_by_value()
    {
        $this->assertEquals(Bevs::BREW, Bevs::fromValue('Corona'));
        $this->assertEquals(Bevs::RUM, Bevs::fromValue('Bundaberg'));
    }

    public function test_flipable_trait_throws_exception_with_invalid_value()
    {
        $this->expectException(InvalidValueException::class);
        $this->assertEquals(Bevs::BREW, Bevs::fromValue('Water'));
    }

    public function test_get_instance_via_key()
    {
        $animal = Animal::instanceFromKey('kitty');
        $this->assertTrue($animal->is(Animal::CAT()));
    }

    public function test_get_instance_via_invalid_key_throws_exception()
    {
        $this->expectException(InvalidKeyException::class);
        Animal::instanceFromKey('_invalid_key_');
    }
}
