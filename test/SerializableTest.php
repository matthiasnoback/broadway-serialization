<?php

namespace BroadwaySerialization\Test;

use BroadwaySerialization\OcramiusReconstitute;
use BroadwaySerialization\Reconstitution;
use Doctrine\Instantiator\Instantiator;

class SerializableTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        Reconstitution::reconstituteUsing(
            new OcramiusReconstitute(new Instantiator(), null)
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
