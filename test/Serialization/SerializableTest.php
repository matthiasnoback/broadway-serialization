<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Serialization;

use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Reconstitution\Reconstitution;
use BroadwaySerialization\Test\Serialization\Fixtures\SerializableObjectUsingTrait;
use BroadwaySerialization\Test\Serialization\Fixtures\SerializableObjectWithNoCallbacks;
use BroadwaySerialization\Test\Serialization\Fixtures\TraditionalSerializableObject;
use Doctrine\Instantiator\Instantiator;
use PHPUnit\Framework\TestCase;

final class SerializableTest extends TestCase
{
    protected function setUp(): void
    {
        Reconstitution::reconstituteUsing(
            new ReconstituteUsingInstantiatorAndHydrator(new Instantiator(), new HydrateUsingReflection())
        );
    }

    /**
     * @test
     */
    public function it_serializes_and_deserializes_objects_successfully()
    {
        $originalObject = new SerializableObjectUsingTrait(
            // simple scalar value
            'foo',
            // object
            new TraditionalSerializableObject('baz'),
            // array of objects
            [
                new TraditionalSerializableObject('baz'),
                new TraditionalSerializableObject('baz')
            ]
        );

        $data = $originalObject->serialize();
        $reconstitutedInstance = SerializableObjectUsingTrait::deserialize($data);

        $this->assertEquals($originalObject, $reconstitutedInstance);
    }

    /**
     * @test
     */
    public function it_has_no_custom_callbacks_by_default()
    {
        $originalObject = new SerializableObjectWithNoCallbacks('baz');

        $data = $originalObject->serialize();
        $reconstitutedInstance = SerializableObjectWithNoCallbacks::deserialize($data);

        $this->assertEquals($originalObject, $reconstitutedInstance);
    }
}
