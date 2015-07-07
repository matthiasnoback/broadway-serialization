<?php

namespace BroadwaySerialization\Hydration;

use GeneratedHydrator\Configuration;
use Zend\Stdlib\Hydrator\HydratorInterface;

class HydrateUsingGeneratedHydrator implements Hydrate
{
    /**
     * @var string|null
     */
    private $cacheDir;

    /**
     * @var HydratorInterface[]
     */
    private $generatedHydrators = [];

    public function __construct($cacheDir)
    {
        \Assert\that($cacheDir)->nullOr()->directory();
        $this->cacheDir = $cacheDir;
    }

    public function hydrate(array $data, $object)
    {
        $hydrator = $this->hydratorFor($object);

        // this makes sure we have data for all currently existing properties
        $defaultData = $hydrator->extract($object);

        $hydrator->hydrate(array_replace($defaultData, $data), $object);
    }

    /**
     * @param object $object
     * @return HydratorInterface
     */
    private function hydratorFor($object)
    {
        $className = get_class($object);

        if (!isset($this->generatedHydrators[$className])) {
            $configuration = new Configuration($className);

            if ($this->cacheDir !== null) {
                $configuration->setGeneratedClassesTargetDir($this->cacheDir);
            }

            $hydratorClass = $configuration->createFactory()->getHydratorClass();

            $this->generatedHydrators[$className] = new $hydratorClass();
        }

        return $this->generatedHydrators[$className];
    }
}
