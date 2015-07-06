<?php

namespace BroadwaySerialization\Reconstitution;

use BroadwaySerialization\Hydration\Hydrate;
use BroadwaySerialization\Reconstitution\Reconstitute;
use Doctrine\Instantiator\InstantiatorInterface;

/**
 * Uses doctrine/instantiator and ocramius/generated-hydrator to reconstitute objects
 */
class ReconstituteUsingInstantiatorAndHydrator implements Reconstitute
{
    /**
     * @var InstantiatorInterface
     */
    private $instantiator;

    /**
     * @var Hydrate
     */
    private $hydrator;

    /**
     * @param InstantiatorInterface $instantiator
     * @param string|null $cacheDirectory Where to store the generated hydrator classes
     */
    public function __construct(InstantiatorInterface $instantiator, Hydrate $hydrator)
    {
        $this->instantiator = $instantiator;
        $this->hydrator = $hydrator;
    }

    /**
     * @inheritdoc
     */
    public function objectFrom($className, array $data)
    {
        $object = $this->instantiator->instantiate($className);

        $this->hydrator->hydrate($data, $object);

        return $object;
    }
}
