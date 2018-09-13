<?php

namespace Rexlabs\Enum;

use Rexlabs\Enum\Exceptions\InvalidEnumException;
use Rexlabs\Enum\Exceptions\InvalidKeyException;
use Rexlabs\Enum\Exceptions\InvalidValueException;

/**
 * Enum implementation.
 *
 * @author    Jodie Dunlop <jodie.dunlop@rexsoftware.com.au>
 * @copyright 2018 Rex Software Pty Ltd
 */
abstract class Enum
{
    /** @var array Cache of CONSTANT identifier => value per class */
    public static $constants = [];

    /** @var array Cache of what map() returns per class */
    public static $cachedMap = [];

    /** @var string */
    protected $identifier;

    /** @var mixed */
    protected $key;

    /** @var mixed */
    protected $value;

    /**
     * Enum constructor.
     *
     * @param string $identifier
     * @param mixed  $key
     * @param mixed  $value
     */
    public function __construct(string $identifier, $key, $value)
    {
        $this->identifier = $identifier;
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Return the keys for the map
     *
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(static::cachedMap());
    }

    /**
     * Returns a cached version of the map
     * It not only ensures the array supplied by map() is indexed by key,
     * it allows map() to do any intensive one-off operations.
     *
     * @return array
     */
    public static function cachedMap(): array
    {
        // Ensure the map is indexed by key
        $class = static::class;
        if (!isset(static::$cachedMap[$class])) {
            $cache = null;
            $map = static::map();
            if (!empty($map)) {
                $isAssoc = array_keys($map) !== range(0, \count($map) - 1);
                $cache = $isAssoc ? $map : array_fill_keys(array_values($map), null);
            } else {
                // No mapping is defined, use the const keys
                $cache = array_fill_keys(array_values(static::constantMap()), null);
            }
            static::$cachedMap[$class] = $cache;
        }

        return static::$cachedMap[$class];
    }

    /**
     * Returns an array of $key => $value.
     * If an empty array is returned, the declared const keys will be used.
     *
     * @return array
     */
    public static function map(): array
    {
        return [];
    }

    /**
     * Return flipped map where keys become values and vice versa
     *
     * @return array
     */
    public static function flip(): array
    {
        return array_flip(static::map()) ?? [];
    }

    /**
     * Return the values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_values(static::cachedMap());
    }

    /**
     * Return the constant identifiers
     *
     * @return array
     */
    public static function identifiers(): array
    {
        return array_keys(static::constantMap());
    }

    /**
     * Return a map of constant identifiers and their assigned key value.
     *
     * @return array
     */
    public static function constantMap(): array
    {
        $class = static::class;
        if (!array_key_exists($class, static::$constants)) {
            static::$constants[$class] = (new \ReflectionClass($class))->getConstants();
        }

        return static::$constants[$class];
    }

    /**
     * Handle calls to class::SOME_CONSTANT() and returns a new instance of the class.
     *
     * @param string $name
     * @param array  $arguments
     *
     * @return static
     * @throws InvalidKeyException
     * @throws InvalidEnumException
     */
    public static function __callStatic($name, $arguments)
    {
        $key = static::getKeyForIdentifier($name);
        if ($key === null) {
            throw new InvalidEnumException("Invalid constant identifier '{$name}' in " . static::class);
        }

        return new static($name, $key, static::valueFor($key));
    }

    /**
     * Get the key for the given constant identifier
     *
     * @param string $identifier
     *
     * @return null|mixed|string
     */
    public static function getKeyForIdentifier(string $identifier)
    {
        $key = null;
        $map = static::constantMap();

        return $map[$identifier] ?? null;
    }

    /**
     * Get the value for a given key
     *
     * @param mixed|string $key
     *
     * @return mixed
     * @throws InvalidKeyException
     */
    public static function valueFor($key)
    {
        static::checkExists($key);

        return static::cachedMap()[$key];
    }

    /**
     * Returns the constant for a given value
     *
     * @param str|int $value
     * @return Mixed
     */
    public static function fromValue($value)
    {
        $flipped = static::flip();
        if ( ! array_key_exists( $value, $flipped )) {
            throw new InvalidValueException("Value '{$value}' not found in map for " . static::class);
        }

        return $flipped[$value];
    }

    /**
     * Create instance of this Enum from the key.
     *
     * @param string|int $key
     *
     * @return static
     * @throws InvalidKeyException
     */
    public static function instanceFromKey($key): self
    {
        foreach (self::constantMap() as $identifier => $validKey) {
            if ($key === $validKey) {
                return static::{$identifier}();
            }
        }

        throw new InvalidKeyException(sprintf('Invalid key: %s in %s', $key, static::class));
    }

    /**
     * Determine if a key exists within the constant map
     *
     * @param mixed|string $key
     *
     * @return boolean
     */
    public static function exists($key): bool
    {
        return array_key_exists($key, static::cachedMap());
    }

    /**
     * Check if the key exists or throw an exception
     *
     * @param mixed|string $key
     *
     * @throws InvalidKeyException
     */
    public static function checkExists($key)
    {
        if (!static::exists($key)) {
            throw new InvalidKeyException("Invalid key: $key in " . static::class);
        }
    }

    /**
     * @param string $identifier
     *
     * @return bool
     */
    public static function identifierExists(string $identifier): bool
    {
        return static::getKeyForIdentifier($identifier) !== null;
    }

    /**
     * Returns the identifier (constant).
     * Same as $enum->identifier().
     *
     * @return string
     */
    public function __toString()
    {
        return $this->identifier();
    }

    /**
     * Returns the identifier (constant).
     *
     * @return string
     */
    public function identifier(): string
    {
        return $this->identifier;
    }

    /**
     * Returns the value assigned to the constant declaration.
     *
     * @return mixed|string
     */
    public function key(): string
    {
        return $this->key;
    }

    /**
     * Returns the mapped value (null if no value is assigned)
     *
     * @return mixed|null
     */
    public function value()
    {
        return $this->value;
    }

    /**
     * Returns true if this instance is equal to the given key or Enum instance.
     *
     * @param Enum|string $compare
     *
     * @return bool
     * @throws InvalidEnumException
     */
    public function is($compare): bool
    {
        if ($compare instanceof self) {
            return $compare->identifier() === $this->identifier();
        }

        if (\is_string($compare)) {
            return $compare === $this->key();
        }

        throw new InvalidEnumException('Enum or string expected but ' . \gettype($compare) . ' given.');
    }
}
