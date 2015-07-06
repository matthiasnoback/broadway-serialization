<?php

namespace BroadwaySerialization;

use Doctrine\Instantiator\InstantiatorInterface;
use GeneratedHydrator\Configuration;
use Zend\Stdlib\Hydrator\HydratorInterface;

/**
 * Uses doctrine/instantiator and ocramius/generated-hydrator to reconstitute objects
 */
class OcramiusReconstitute implements Reconstitute
{
    /**
     * @var string
     */
    private $cacheDirectory;

    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @param InstantiatorInterface $instantiator
     * @param string|null $cacheDirectory Where to store the generated hydrator classes
     */
    public function __construct(InstantiatorInterface $instantiator, $cacheDirectory)
    {
        \Assert\that($cacheDirectory)->nullOr()->string()->directory('Invalid cache directory');
        $this->cacheDirectory = $cacheDirectory;

        $this->instantiator = $instantiator;
    }

    /**
     * @inheritdoc
     */
    public function objectFrom($className, array $data)
    {
        $object = $this->instantiator->instantiate($className);

        $this->hydratorFor($className)->hydrate($data, $object);

        return $object;
    }

    /**
     * @param string $className
     * @return HydratorInterface
     */
    private function hydratorFor($className)
    {
        $configuration = new Configuration($className);
        if ($this->cacheDirectory !== null) {
            $configuration->setGeneratedClassesTargetDir($this->cacheDirectory);
        }

        $hydratorClass = $configuration->createFactory()->getHydratorClass();
        $hydrator = new $hydratorClass();

        return $hydrator;
    }
}
