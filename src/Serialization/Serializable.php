<?php

namespace BroadwaySerialization\Serialization;

use BroadwaySerialization\Reconstitution\Reconstitution;

/**
 * Use this trait in classes that implement \Broadway\Serializer\SerializableInterface to make them automatically fully
 * serializable. If properties need to be deserialized to objects, you need to override the `deserializationCallbacks()`
 * method as well. See \BroadwaySerialization\Serializable::deserializationCallbacks().
 */
trait Serializable
{
    /**
     * @see \Broadway\Serializer\SerializableInterface::deserialize()
     *
     * @param array $data
     * @return object of type static::class
     */
    final public static function deserialize(array $data)
    {
        return Reconstitution::reconstitute()->objectFrom(
            get_called_class(),
            RecursiveSerializer::deserialize($data, self::deserializationCallbacks())
        );
    }

    /**
     * @see \Broadway\Serializer\SerializableInterface::serialize()
     *
     * @return array Values of properties that should be serialized
     */
    final public function serialize()
    {
        return RecursiveSerializer::serialize(get_object_vars($this));
    }

    /**
     * Override this function if specific properties contain objects that need to be deserialized as well. Return an
     * array of which each key corresponds to an existing property and each value is a callable which handles the
     * deserialization:
     *
     *   [
     *     'property' => [DesiredClass::class, 'deserialize']
     *   ]
     *
     * @return array
     */
    protected static function deserializationCallbacks()
    {
        return [];
    }
}
