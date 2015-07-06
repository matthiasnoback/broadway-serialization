<?php

namespace BroadwaySerialization;

final class ArrayHelper
{
    /**
     * Find out if the given array is numerically indexed?
     *
     * @param array $values
     * @return bool
     */
    public static function isNumericallyIndexed(array $values)
    {
        if (empty($values)) {
            return true;
        }

        reset($values);

        return is_int(key($values));
    }
}
