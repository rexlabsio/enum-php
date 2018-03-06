# Enum PHP Library

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Build Status](https://travis-ci.org/rexlabsio/enum-php.svg?branch=master)](https://travis-ci.org/rexlabsio/enum-php)
[![Code Coverage](https://scrutinizer-ci.com/g/rexlabsio/enum-php/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/rexlabsio/enum-php/?branch=master)
[![Packagist](https://img.shields.io/packagist/v/rexlabs/enum.svg)](https://packagist.org/packages/rexlabs/enum)


## Overview

This library provides an Enum / Enumeration implementation for PHP.

## Why use this library

* Very simple to implement and use.
* Flexible values can be assigned.
* Allows type-hinting when passing enumerated values between methods and classes.

## Usage

### Extend the Enum class

Extending the `Enum` class is simple;

1. Simply declare any constants
2. *Optional*: provide a `map()` method:

```php
<?php
namespace MyProject\Enum;

use Rexlabs\Enum\Enum;

class Animal extends Enum
{
    // Declare any constants and their 'key'
    const CAT = 'kitty';
    const DOG = 'dog';
    const HORSE = 'horse';
    const PIGEON = 'skyrat';
    
    // Optional: Provide a map() method to assign values to your keys.
    // Your map method should return an array key => optional value
    public static function map(): array
    {
        return [
            self::CAT => 'Kitty-cat',       
            self::DOG => null,
            self::HORSE => null,
            self::PIGEON => ['you','filthy','animal'],
        ];
    }
}
```

### Use your extended class

```php
<?php
use MyProject\Enum\Animal;

// Via class constant
echo Animal::CAT;                   // "kitty"

// Get an Animal instance for 'CAT'
$cat = Animal::CAT();               // (object)Animal
$cat->identifier();                 // "CAT"  
$cat->key();                        // "kitty"
$cat->value();                      // "Kitty-cat"
$cat->is(Animal::CAT);              // (boolean)true
$cat->is(Animal::CAT());            // (boolean)true
$cat->is(Animal::PIGEON());         // (boolean)false

Animal::DOG()->value();             // (null)  - No value was assigned in map()

Animal::PIGEON()->key();            // "skyrat"
Animal::PIGEON()->value();          // (array)['you', 'filthy', 'animal']
```

## Dependencies

- PHP 7.0 or above.

## Installation

To install in your project:

```bash
composer require rexlabs/enum
```

## More Examples


### Type-hinting

Now you can type-hint your `Enum` object as a dependency:

```php
<?php
function sayHelloTo(Animal $animal) {
    $name = $animal->value() ?? $animal->key();
    if (is_array($name)) {
        $name = implode(' ', $name);
    }
    
    echo "Greeting for {$animal->identifier()}: Hello $name\n";
   
}

// Get a new instance
sayHelloTo(Animal::CAT());      // "Greeting for CAT: Hello Kitty-cat"
sayHelloTo(Animal::DOG());      // "Greeting for DOG: Hello dog" 
sayHelloTo(Animal::PIGEON());   // "Greeting for PIGEON: Hello you filthy animal" 
```


## Instance Methods

Each instance of `Enum` provides the following methods:

### identifier()

Returns the constant identifier.

```php
$enum->identifier();
```

### key()

Returns the value/key assigned to the constant in the `const MY_CONST = 'key'` declaration.

```php
$enum->key();
```

### value()

Returns the value (if-any) that is mapped (in the array returned by `map()`).
If no value is mapped, then this method returns `null`.

```php
$enum->value();
```

### is(Enum|string $compare)

Returns true if this instance is the same as the given constant string or enumeration instance.

```php
$enum->is(Animal::CAT);       // Compare to constant key
$enum->is(Animal::CAT());     // Compare to instance
```

### __toString()

The `__toString()` method is defined to return the instance identifier (constant name).

```php
(string)Animal::CAT();      // "CAT"
```


## Static Methods

### map()

Returns an array which maps the constants, and any values.  This method is implemented in a sub-class.

### keys()

Returns an array of constant keys.

### values()

Returns an array of values defined in `map()`. If `map()` is not implemented then an array of null values will
be returned.

### identifiers()

Returns an array of all the constant identifiers declared with `const MY_CONST = 'key'`

### constantMap()

Returns an array of CONST => key, for all of the constant identifiers declared with `const MY_CONST = 'key'`.

### getKeyForIdentifier(string $identifier)

Returns the key for the given constant identifier.

### identifierExists(string $identifier)

Returns true if the given identifier is declared as a `const` within the class.

### valueFor(string $key)

Returns the value (or null if not mapped) for the given key (as declared in the `map()` method).

### exists(string $key)

Returns true if the given key exists.

### checkExists(string $key)

Throws a `InvalidArgumentException` if the given key does NOT exist.

## Tests

To run tests:
```bash
composer tests
```

To run coverage report:
```bash
composer coverage
```
Coverage report is output to `./tests/report/index.html`

## Contributing

Contributions are welcome, please submit a pull-request or create an issue.
Your submitted code should be formatted using PSR-1/PSR-2 standards.

## About

- Author: [Jodie Dunlop](https://github.com/jodiedunlop)
- License: [MIT](LICENSE)
- Copyright (c) 2018 Rex Software Pty Ltd
