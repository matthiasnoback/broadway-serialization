<?php

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\AutoSerializable;

class SomeOtherSerializableClassUsingTrait implements SerializableInterface
{
    use AutoSerializable;

    private $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }
}
