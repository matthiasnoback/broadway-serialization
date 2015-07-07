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

    private $deserializationData = [
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
    ];

    protected function classSetUp()
    {
        $this->traditionalSerializableClass = new TraditionalSerializableClass();
        $this->serializableClassUsingTrait = new SerializableClassUsingTrait();

        $reconstitute = new ReconstituteUsingInstantiatorAndHydrator(new Instantiator(), new HydrateUsingReflection());

        // test run, for calibration
        $reconstitute->objectFrom('BroadwaySerialization\Test\Performance\SerializableClassUsingTrait', []);
        $reconstitute->objectFrom('\BroadwaySerialization\Test\Performance\SomeOtherSerializableClassUsingTrait', []);

        Reconstitution::reconstituteUsing($reconstitute);
    }

    /**
     * @iterations 1000
     */
    public function serializeObjectWithOnlyScalarProperties()
    {
        $this->traditionalSerializableClass->serialize();
    }

    /**
     * @iterations 1000
     */
    public function deserializeTraditionalObject()
    {
        TraditionalSerializableClass::deserialize($this->deserializationData);
    }

    /**
     * @iterations 1000
     */
    public function serializeObjectWithOnlyScalarPropertiesWithTrait()
    {
        $this->serializableClassUsingTrait->serialize();
    }

    /**
     * @iterations 1000
     */
    public function deserializeObjectUsingTrait()
    {
        SerializableClassUsingTrait::deserialize($this->deserializationData);
    }
}
