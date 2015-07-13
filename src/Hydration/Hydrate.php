<?php

namespace BroadwaySerialization\Hydration;

/**
 * Used by {@see \BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator} to copy data into a
 * previously instantiated object.
 */
interface Hydrate
{
    /**
     * Copy the provided data into the properties of the provided object
     *
     * @param object $object
     * @param array $data
     * @return void
     */
    public function hydrate(array $data, $object);
}
