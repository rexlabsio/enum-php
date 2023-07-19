# 2.3.0

- Limit support explicitly to PHP 7.0-8.2

# 2.2.0

- Add `isNot`, `isAnyOf`, `isNoneOf` expressive methods

# 2.1.0

- Add Enum::instances method to load set of all instances

# 2.0.2

- Fix bug where const val=0 could not load instance

# 2.0.1

- Show class name in error when comparing enum with an invalid object.

# 2.0.0

This release is a significant overhaul of the existing API, and therefore introduces breaking changes.
See the list of updates below, and consult the [README](./README.md) for examples and details of the new API.

- Add Enum::instanceFromKey($key)
- **Breaking** Change `$instance->identifier` to `$instance->name()`
- **Breaking** Change `Enum::identifiers()` to `Enum::names()`
- **Breaking** Change `Enum::getKeyForIdentfier()` to `Enum::keyForName()`
- **Breaking** Change `Enum::valueFor()` to `Enum::valueForKey()`
- Add `Enum::nameForKey()` to get the constant name for a given key
- **Breaking** Change `Enum::exists()` to `Enum::isValidKey()`
- **Breaking** Change `Enum::checkExists()` to `Enum::requireValidKey()`
- Fix `$instance->key()` to handle non-string keys
- Fix `$instance->is()` to handle non-string keys
- Fix late-static binding in some methods which referred to `self::`
- Add `Enum::instanceFromName($name)` to get an instance via name (alternative to Enum::NAME())
- Change implementation of `Enum::instanceFromKey($key)` to use array_search
- **Breaking** Change: the default provided static `map()` method will return an array of constant keys mapped to `null`. 
Previously it returned an empty array `[]` when not overridden. In practice, this may not effect userland code.
- **Breaking** Change: you can no longer provide a non-keyed array in an `map()` method implemented
in your sub-class.  This method should be used to map keys to values (if necessary).  A default map() method is provided
which maps keys to `null` values.
- **Breaking** Change `Enum::fromValue($val)` has been renamed to `Enum::keyForValue()`
- **Breaking** Change: removed `Enum::flip()`
- **Breaking** Change `Enum::constantMap()` to `Enum::namesAndKeys()`
- Updated README to reflect API changes
- Add `Enum::valueForName($name)` for completeness

# 1.1.0

- Add flip() and fromValue()

# 1.0.0

- initial release

