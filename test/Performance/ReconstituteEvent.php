<?php

namespace BroadwaySerialization\Test\Performance;

use Athletic\AthleticEvent;
use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Hydration\HydrateUsingGeneratedHydrator;
use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\Reconstitute;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Reconstitution\Reconstitution;
use Doctrine\Instantiator\Instantiator;

class ReconstituteEvent extends AthleticEvent
{
    private $deserializeData = [
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
    /**
     * @var SerializableInterface
     */
    private $traditionalSerializableClass;

    /**
     * @var SerializableInterface
     */
    private $serializableClassUsingTrait;

    /**
     * @var Reconstitute
     */
    private $reconstituteUsingReflection;

    /**
     * @var Reconstitute
     */
    private $reconstituteUsingGeneratedHydrator;

    protected function setUp()
    {
        $this->traditionalSerializableClass = new TraditionalSerializableClass();
        $this->serializableClassUsingTrait = new SerializableClassUsingTrait();

        $instantiator = new Instantiator();
        $this->reconstituteUsingReflection = new ReconstituteUsingInstantiatorAndHydrator(
            $instantiator,
            new HydrateUsingReflection()
        );
        $this->reconstituteUsingGeneratedHydrator = new ReconstituteUsingInstantiatorAndHydrator(
            new Instantiator(),
            new HydrateUsingGeneratedHydrator(null)
        );

        // test run, to trigger class generation:
        $this->reconstituteUsingGeneratedHydrator->objectFrom('BroadwaySerialization\Test\Performance\SerializableClassUsingTrait', []);

        $this->reconstituteUsingGeneratedHydrator->objectFrom('BroadwaySerialization\Test\Performance\SomeOtherSerializableClassUsingTrait', []);
    }

    /**
     * @iterations 1000
     */
    public function traditional_serialize()
    {
        $data = $this->traditionalSerializableClass->serialize();
    }

    /**
     * @iterations 1000
     */
    public function traditional_deserialize()
    {
        $object = TraditionalSerializableClass::deserialize($this->deserializeData);
    }

    /**
     * @iterations 1000
     */
    public function reflection_serialize()
    {
        $this->useReflection();

        $data = $this->serializableClassUsingTrait->serialize();
    }

    /**
     * @iterations 1000
     */
    public function reflection_deserialize()
    {
        $this->useReflection();

        $object = SerializableClassUsingTrait::deserialize($this->deserializeData);
    }

    /**
     * @iterations 1000
     */
    public function generated_hydrator_serialize()
    {
        $this->useGeneratedHydrator();

        $data = $this->serializableClassUsingTrait->serialize();
    }

    /**
     * @iterations 1000
     */
    public function generated_hydrator_deserialize()
    {
        $this->useGeneratedHydrator();

        $object = SerializableClassUsingTrait::deserialize($this->deserializeData);
    }

    private function useGeneratedHydrator()
    {
        Reconstitution::reconstituteUsing($this->reconstituteUsingGeneratedHydrator);
    }

    private function useReflection()
    {
        Reconstitution::reconstituteUsing($this->reconstituteUsingReflection);
    }
}
