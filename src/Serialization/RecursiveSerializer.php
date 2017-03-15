<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Serialization;

use Broadway\Serializer\Serializable;

/**
 * Helper class for recursively preparing (property) values for (de)serialization.
 *
 * @private
 */
final class RecursiveSerializer
{
    /**
     * Recursively serialize an array of (property) values.
     *
     * @param array $values
     * @return array
     */
    public static function serialize(array $values): array
    {
        $serializedData = [];

        foreach ($values as $property => $value) {
            if (is_array($value)) {
                $value = self::serialize($value);
            }

            if ($value instanceof Serializable) {
                $value = $value->serialize();
            }

            $serializedData[$property] = $value;
        }

        return $serializedData;
    }

    /**
     * Recursively deserialize an array of (property) values. Use callbacks to further deserialize more complicated
     * values.
     *
     * @param array $values
     * @param array $callbacks
     * @return array
     */
    public static function deserialize(array $values, array $callbacks = []): array
    {
        $deserializedData = [];
        foreach ($values as $property => $value) {
            if (isset($callbacks[$property])) {
                if (is_array($value) && ArrayHelper::isNumericallyIndexed($value)) {
                    $value = array_map($callbacks[$property], $value);
                } elseif ($value !== null) {
                    // if $value is null, we don't call the callable, since its type-hint may then cause a fatal error
                    $value = $callbacks[$property]($value);
                }
            }

            $deserializedData[$property] = $value;
        }

        return $deserializedData;
    }
}
