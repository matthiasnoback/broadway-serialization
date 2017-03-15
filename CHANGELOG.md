# Changelog

- `v2.0.0` Upgrade to PHP 7.0 and some more modernization:
    - Use type-hints wherever possible.
    - Use `::class` constants wherever possible.
    - 
- `v1.2.0` Upgrade to Broadway 1.0:
    - Use `Broadway\Serializer\Serializable` instead of `Broadway\Serializer\SerializableInterface`.
    - Rename `BroadwaySerialization\Serialization\Serializable` to `BroadwaySerialization\Serialization\AutoSerializable` so the user doesn't need to alias the `Serializable` interface.
 
- `v1.1.1` Start keeping a changelog.
