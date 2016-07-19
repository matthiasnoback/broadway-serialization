<?php

namespace BroadwaySerialization\Hydration;

class HydrateUsingClosure implements Hydrate
{
    /** @var \Closure */
    private $hydrator;

    /**
     * @var $cache $cache[FQCN][property] = true means property exists
     */
    private $cache = [];

    /**
     * Creates a closure which is to be bound to an instance
     */
    public function __construct()
    {
        $this->hydrator = function (array $data, array $props) {
            foreach ($data as $key => $value) {
                if (isset($props[$key])) {
                    $this->{$key} = $value;
                }
            }
        };
    }

    /**
     * {@inheritdoc}
     */
    public function hydrate(array $data, $object)
    {
        $class = get_class($object);
        if (!isset($this->cache[$class])) {
            $this->getProps($class);
        }

        $this->hydrator->call($object, $data, $this->cache[$class]);
    }

    /**
     * @param $class
     */
    private function getProps($class)
    {
        $this->cache[$class] = [];
        foreach ((new \ReflectionClass($class))->getProperties() as $property) {
            $this->cache[$class][$property->getName()] = true;
        }
    }
}