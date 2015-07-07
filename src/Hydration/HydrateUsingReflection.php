<?php

namespace BroadwaySerialization\Hydration;

/**
 * Simple implementation of a hydrator, which uses reflection to iterate over the properties of an object
 */
class HydrateUsingReflection implements Hydrate
{
    /**
     * @var array An array of arrays of \ReflectionProperty instances
     */
    private $properties = [];

    public function hydrate(array $data, $object)
    {
        foreach ($this->propertiesOf($object) as $property) {
            if (!isset($data[$property->getName()])) {
                continue;
            }

            $property->setValue($object, $data[$property->getName()]);
        }
    }

    /**
     * @param object $object
     * @return \ReflectionProperty[]
     */
    private function propertiesOf($object)
    {
        $className = get_class($object);

        if (!isset($this->properties[$className])) {
            $this->properties[$className] = (new \ReflectionObject($object))->getProperties();
            foreach ($this->properties[$className] as $property) {
                /** @var \ReflectionProperty $property */
                $property->setAccessible(true);
            }
        }

        return $this->properties[$className];
    }
}
