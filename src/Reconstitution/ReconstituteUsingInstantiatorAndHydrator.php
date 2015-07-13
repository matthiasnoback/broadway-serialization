<?php

namespace BroadwaySerialization\Reconstitution;

use BroadwaySerialization\Hydration\Hydrate;
use Doctrine\Instantiator\InstantiatorInterface;

/**
 * Uses doctrine/instantiator and a Hydrate instance to reconstitute objects
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
     * @param Hydrate $hydrator
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
