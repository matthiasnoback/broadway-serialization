<?php

namespace BroadwaySerialization\Test\Performance;

use Athletic\AthleticEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Reconstitution\Reconstitution;
use Doctrine\Instantiator\Instantiator;

class ReconstituteEvent extends AthleticEvent
{
    /**
     * @var SerializableInterface
     */
    private $traditionalSerializableClass;

    /**
     * @var SerializableInterface
     */
    private $serializableClassUsingTrait;

    protected function setUp()
    {
        $this->traditionalSerializableClass = new TraditionalSerializableClass();
        $this->serializableClassUsingTrait = new SerializableClassUsingTrait();

        $reconstitute = new ReconstituteUsingInstantiatorAndHydrator(new Instantiator(), new HydrateUsingReflection());
        // test run, to trigger class generation:
        $reconstitute->objectFrom('BroadwaySerialization\Test\Performance\SerializableClassUsingTrait', []);

        Reconstitution::reconstituteUsing($reconstitute);
    }

    /**
     * @iterations 1000
     */
    public function serializeObjectWithOnlyScalarProperties()
    {
        $data = $this->traditionalSerializableClass->serialize();
    }

    /**
     * @iterations 1000
     */
    public function deserializeTraditionalObject()
    {
        $object = TraditionalSerializableClass::deserialize([
            'stringProperty' => 'foo',
            'integerProperty' => 20,
            'nullProperty' => null,
            'arrayProperty' => ['foo' => 'bar', 'bar' => 'baz'],
            'objectProperty' => [
                'foo' => 'foo',
            ],
            'objectsProperty' => [
                [
                    'foo' => 'bar',
                ],
                [
                    'foo' => 'baz',
                ],
            ]
        ]);
    }

    /**
     * @iterations 1000
     */
    public function serializeObjectWithOnlyScalarPropertiesWithTrait()
    {
        $data = $this->serializableClassUsingTrait->serialize();
    }

    /**
     * @iterations 1000
     */
    public function deserializeObjectUsingTrait()
    {
        $object = SerializableClassUsingTrait::deserialize([
            'stringProperty' => 'foo',
            'integerProperty' => 20,
            'nullProperty' => null,
            'arrayProperty' => ['foo' => 'bar', 'bar' => 'baz'],
            'objectProperty' => [
                'foo' => 'foo',
            ],
            'objectsProperty' => [
                [
                    'foo' => 'bar',
                ],
                [
                    'foo' => 'baz',
                ],
            ]
        ]);
    }
}
