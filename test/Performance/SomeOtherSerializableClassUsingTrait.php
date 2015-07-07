<?php

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\SerializableInterface;

class SomeOtherSerializableClassUsingTrait implements SerializableInterface
{
    use \BroadwaySerialization\Serialization\Serializable;

    private $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }
}
