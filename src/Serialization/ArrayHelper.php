<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Serialization;

final class ArrayHelper
{
    /**
     * Find out if the given array is numerically indexed?
     *
     * @param array $values
     * @return bool
     */
    public static function isNumericallyIndexed(array $values): bool
    {
        if (empty($values)) {
            return true;
        }

        reset($values);

        return is_int(key($values));
    }
}
