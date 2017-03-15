<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Reconstitution;

use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Test\Serialization\Fixtures\TraditionalSerializableObject;
use Doctrine\Instantiator\Instantiator;
use PHPUnit\Framework\TestCase;

final class InstantiateAndHydrateTest extends TestCase
{
    /**
     * @test
     */
    public function it_reconstitutes_a_serialized_object()
    {
        $reconstitute = new ReconstituteUsingInstantiatorAndHydrator(new Instantiator(), new HydrateUsingReflection());

        $className = TraditionalSerializableObject::class;
        $data = ['bar' => 'baz'];
        $object = $reconstitute->objectFrom($className, $data);

        $this->assertInstanceOf($className, $object);
        $this->assertSame($data['bar'], $object->getBar());
    }
}
