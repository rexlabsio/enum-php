<?php

namespace Rexlabs\Enum\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rexlabs\Enum\Tests\Stub\Animal;
use Rexlabs\Enum\Tests\Stub\Fruit;
use Rexlabs\Enum\Tests\Stub\Number;

class EnumTest extends TestCase
{
    public function test_can_get_names()
    {
        self::assertEquals([
            'APPLE',
            'BANANA',
            'CHERRY',
            'EGGPLANT',
            'AUBERGINE',
        ], Fruit::names());

        self::assertEquals([
            'CAT',
            'DOG',
            'HORSE',
            'PIGEON',
        ], Animal::names());
    }

    public function test_can_get_keys()
    {
        self::assertEquals([
            Fruit::APPLE,
            Fruit::BANANA,
            Fruit::CHERRY,
            Fruit::EGGPLANT,
            Fruit::AUBERGINE,
        ], Fruit::keys());

        self::assertEquals([
            Animal::CAT,
            Animal::DOG,
            Animal::HORSE,
            Animal::PIGEON,
        ], Animal::keys());
    }

    public function test_can_get_values()
    {
        // Number does not provide a map() method and therefore all keys are
        // by default mapped to a value of null
        self::assertEquals([
            null,
            null,
            null,
            null,
        ], Number::values());

        // When map() is defined, should return all of the mapped values
        self::assertEquals([
            'Kitty-cat',
            null,
            null,
            ['you', 'filthy', 'animal'],
        ], Animal::values());
    }

    public function test_can_get_instances()
    {
        $instances = Animal::instances();

        foreach ($instances as $animal) {
            self::assertInstanceOf(Animal::class, $animal);
        }

        $keys = array_map(function (Animal $animal) {
            return $animal->key();
        }, $instances);

        self::assertEquals([
            Animal::CAT,
            Animal::DOG,
            Animal::HORSE,
            Animal::PIGEON,
        ], $keys);
    }
}
