<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\Serializable;
use BroadwaySerialization\Hydration\HydrateUsingReflection;
use BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator;
use BroadwaySerialization\Reconstitution\Reconstitution;
use Doctrine\Instantiator\Instantiator;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;
use PhpBench\Benchmark\Metadata\Annotations\Groups;
use PhpBench\Benchmark\Metadata\Annotations\Revs;
use PhpBench\Benchmark\Metadata\Annotations\Warmup;

final class BenchSerialization
{
    /**
     * @var Serializable
     */
    private $traditionalSerializableClass;

    /**
     * @var Serializable
     */
    private $serializableClassUsingTrait;

    public function setup()
    {
        $this->traditionalSerializableClass = new TraditionalSerializableClass();
        $this->serializableClassUsingTrait = new SerializableClassUsingTrait();
    }

    public function setupReconstitute()
    {
        $reconstitute = new ReconstituteUsingInstantiatorAndHydrator(new Instantiator(), new HydrateUsingReflection());

        // test run, for calibration
        $reconstitute->objectFrom(SerializableClassUsingTrait::class, []);
        $reconstitute->objectFrom(SomeOtherSerializableClassUsingTrait::class, []);

        Reconstitution::reconstituteUsing($reconstitute);
    }

    /**
     * @Warmup(10)
     * @Revs(100000)
     * @Groups({"traditional"})
     * @BeforeMethods({"setup"})
     */
    public function benchSerializeObjectWithOnlyScalarProperties()
    {
        $this->traditionalSerializableClass->serialize();
    }

    /**
     * @Warmup(10)
     * @Revs(100000)
     * @Groups({"trait"})
     * @BeforeMethods({"setup","setupReconstitute"})
     */
    public function benchSerializeObjectWithOnlyScalarPropertiesWithTrait()
    {
        $this->serializableClassUsingTrait->serialize();
    }
}
