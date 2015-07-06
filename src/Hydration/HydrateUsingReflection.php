<?php

namespace BroadwaySerialization\Hydration;

/**
 * Simple implementation of a hydrator, which uses reflection to iterate over the properties of an object
 */
class HydrateUsingReflection implements Hydrate
{
    public function hydrate(array $data, $object)
    {
        foreach ((new \ReflectionObject($object))->getProperties() as $property) {
            if (!isset($data[$property->getName()])) {
                continue;
            }

            $property->setAccessible(true);
            $property->setValue($object, $data[$property->getName()]);
        }
    }
}
