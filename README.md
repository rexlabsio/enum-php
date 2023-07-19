# Deprecated

> **Warning**
> If you are using PHP 8.1 or higher, we recommend you use [native php enums](https://www.php.net/manual/en/language.enumerations.examples.php) in place  of this package.
> 
> We may release some maintenance patches but support for this package is otherwise being discontinued.
>
> Feel free to fork our code and adapt it to your needs.


# Enum PHP Library

[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](https://opensource.org/licenses/MIT)
[![Packagist](https://img.shields.io/packagist/v/rexlabs/enum.svg)](https://packagist.org/packages/rexlabs/enum)


## Overview

This library provides an Enum / Enumeration implementation for PHP.

## Why use this library

* Very simple to implement and use.
* Complex can optionally be mapped by providing a `map()` method.
* Allows type-hinting when passing enumerated values between methods and classes.

## Usage


First create a new class that extends `\Rexlabs\Enum\Enum` and do the following;

1. Declare your constants
2. *Optional*: provide a `map()` method:

## Example

```php
<?php

namespace Rexlabs\Enum\Readme;

use Rexlabs\Enum\Enum;

/**
 * Class City
 *
 * @package Rexlabs\Enum\Readme
 *
 * @method static static BRISBANE()
 * @method static static MELBOURNE()
 * @method static static SYDNEY()
 */
class City extends Enum
{
    const BRISBANE = 'Brisbane';
    const MELBOURNE = 'Melbourne';
    const SYDNEY = 'Sydney';
    
    // OPTIONAL - Provide a map() method if you would like to
    // map additional data, which will be available from the ->value() method
    public static function map(): array 
    {
        return [
            self::BRISBANE => ["state"=>"QLD", "population"=>""],
            self::MELBOURNE => ["state"=>"VIC", "population"=>"5m"],
            self::SYDNEY => ["state"=>"NSW", "population"=>"5m"],
        ];
    }
    
}

// Static access
echo City::BRISBANE;                 // "Brisbane"
echo City::MELBOURNE;                // "Melbourne"
City::names();                       // (array)["BRISBANE", "BRISBANE", "SYDNEY"]
City::keys();                        // (array)["Brisbane", "Melbourne", "Sydney"]
City::keyForName('BRISBANE');        // "Brisbane"
City::nameForKey('Melbourne');       // "MELBOURNE"
City::isValidKey('Sydney');          // (boolean)true
City::isValidKey('Paris');           // (boolean)false
               
// Getting an instance - all return a City instance.
$city = City::BRISBANE();                   
$city = City::instanceFromName('BRISBANE'); 
$city = City::instanceFromKey('Brisbane');

// Working with an instance
$city->name();                       // "BRISBANE"
$city->key();                        // "Brisbane"
$city->value()['population'];        // null - no value mapped
$city->is(City::BRISBANE);           // (boolean)true
$city->is(City::BRISBANE());         // (boolean)true
$city->is(City::SYDNEY());           // (boolean)false
$city->isNot(City::SYDNEY());        // (boolean)true
$city->isAnyOf([City::BRISBANE()]);  // (boolean)true
$city->isNoneOf([City::BRISBANE()]); // (boolean)false

// Or ...
City::SYDNEY()->key();               // "Sydney"
City::SYDNEY()->value();             // (array)["state"=>"NSW", "population"=>"5m"] 
```

## Dependencies

- PHP 7.0 or above.

## Installation

To install in your project:

```bash
composer require rexlabs/enum
```

### Type-hinting

Now you can type-hint your `Enum` object as a dependency:

```php
<?php
function announceCity(City $city) {
    echo "{$city->key()} is located in {$city->value()["state"]}, population: {$city->value()["population"]}\n";
}

// Get a new instance
announceCity(City::SYDNEY());      // "Sydney is located in NSW, population: 5m"
```


## Instance Methods

Each instance of `Enum` provides the following methods:

### name()

Returns the constant name.

```php
$enum->name();
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

Returns true if this instance is the same as the given constant key or enumeration instance.

```php
$enum->is(City::SYDNEY);       // Compare to constant key
$enum->is(City::SYDNEY());     // Compare to instance
```

### __toString()

The `__toString()` method is defined to return the constant name.

```php
(string)City::SYDNEY();      // "SYDNEY"
```


## Static Methods

### map()

Returns an array which maps the constant keys to a value.
This method can be optionally implemented in a sub-class.
The default implementation returns an array of keys mapped to `null`.

### instances()

Returns an array of Enum instances.

### keys()

Returns an array of constant keys.

### values()

Returns an array of values defined in `map()`. If `map()` is not implemented then an array of null values will
be returned.

### names()

Returns an array of all the constant names declared with the class.

### namesAndKeys()

Returns an associative array of CONSTANT_NAME => key, for all the constant names declared within the class.

### keyForName(string $name)

Returns the key for the given constant name.

### nameForKey(string $key)

Returns the constant name for the given key (the inverse of `keyForName`).

### valueForKey(string $key)

Returns the value (or null if not mapped) for the given key (as declared in the `map()` method).

### keyForValue(mixed $value)

Returns the key for the given value (as declared in the `map()` method).

> Note: If duplicate values are contained within the `map()` method then only the first key will be returned.

### instanceFromName($name)

Create instance of this Enum from the given constant name.

### instanceFromKey($key)

Create instance of this Enum from the given key.

### isValidKey(string $key)

Returns true if the given key exists.

### isValidName(string $name)

Returns true if the given constant name (case-sensitive) has been declared in the class.

### requireValidKey(string $key)

Throws a `\Rexlabs\Enum\Exceptions\InvalidKeyException` if the given key does NOT exist.

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
