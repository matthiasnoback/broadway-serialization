<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Hydration;

/**
 * Simple implementation of a hydrator, which uses reflection to iterate over the properties of an object
 */
final class HydrateUsingReflection implements Hydrate
{
    /**
     * @var array An array of arrays of \ReflectionProperty instances
     */
    private $properties = [];

    /**
     * @inheritdoc
     */
    public function hydrate(array $data, $object)
    {
        foreach ($this->propertiesOf($object) as $name => $property) {
            if (!isset($data[$name])) {
                continue;
            }

            $property->setValue($object, $data[$name]);
        }
    }

    /**
     * @param object $object
     * @return \ReflectionProperty[]
     */
    private function propertiesOf($object): array
    {
        $className = get_class($object);

        if (!isset($this->properties[$className])) {
            $this->properties[$className] = [];
            foreach ((new \ReflectionObject($object))->getProperties() as $property) {
                /** @var \ReflectionProperty $property */
                $property->setAccessible(true);
                $this->properties[$className][$property->getName()] = $property;
            }
        }

        return $this->properties[$className];
    }
}
