<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\Serializable;
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

    /**
     * @Warmup(10)
     * @Revs(1000)
     * @Groups({"traditional"})
     * @BeforeMethods({"setup"})
     */
    public function benchSerializeObjectWithOnlyScalarProperties()
    {
        $this->traditionalSerializableClass->serialize();
    }

    /**
     * @Warmup(10)
     * @Revs(1000)
     * @Groups({"trait"})
     * @BeforeMethods({"setup"})
     */
    public function benchSerializeObjectWithOnlyScalarPropertiesWithTrait()
    {
        $this->serializableClassUsingTrait->serialize();
    }
}
