<?php

namespace BroadwaySerialization\Reconstitution;

/**
 * This class keeps an application-wide instance for reconstituting objects.
 */
final class Reconstitution
{
    /**
     * @var Reconstitute|null
     */
    private static $reconstitute;

    /**
     * @return Reconstitute
     * @throws \LogicException When reconstituteUsing() wasn't called first
     */
    public static function reconstitute()
    {
        if (!self::$reconstitute instanceof Reconstitute) {
            throw new \LogicException(
                'You have to call \BroadwaySerialization\Reconstitution::reconstituteUsing() first'
            );
        }

        return self::$reconstitute;
    }

    /**
     * Provide an object which can reconstitute objects, call this when the application is booting.
     * Provide `null` to free the object reference.
     *
     * @param Reconstitute|null $reconstitute
     * @return void
     * @private
     */
    public static function reconstituteUsing(Reconstitute $reconstitute = null)
    {
        self::$reconstitute = $reconstitute;
    }
}
