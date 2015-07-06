<?php

namespace BroadwaySerialization\Test\Reconstitution;

use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use Doctrine\Instantiator\Instantiator;

class InstantiateAndHydrateTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_reconstitutes_a_serialized_object()
    {
        $reconstitute = new ReconstituteUsingInstantiatorAndHydrator(new Instantiator(), new HydrateUsingReflection());

        $className = 'BroadwaySerialization\Test\Serialization\Fixtures\TraditionalSerializableObject';
        $data = ['bar' => 'baz'];
        $object = $reconstitute->objectFrom($className, $data);

        $this->assertInstanceOf($className, $object);
        $this->assertSame($data['bar'], $object->getBar());
    }
}
