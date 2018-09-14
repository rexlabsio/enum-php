# [Unreleased]

- Add Enum::instanceFromKey($key)
- **Breaking** Change `$instance->identifier` to `$instance->name()`
- **Breaking** Change `Enum::identifiers()` to `Enum::names()`
- **Breaking** Change `Enum::getKeyForIdentfier()` to `Enum::keyForName()`
- **Breaking** Change `Enum::valueFor()` to `Enum::valueForKey()`
- Add `Enum::nameForKey()` to get the constant name for a given key
- **Breaking** Change `Enum::exists()` to `Enum::isValidKey()`
- **Breaking** Change `Enum::checkExists()` to `Enum::requireValidKey()`
- Fix `$instance->key()` to handle non-string keys

# 1.1.0

- Add flip() and fromValue()

# 1.0.0

- initial release

