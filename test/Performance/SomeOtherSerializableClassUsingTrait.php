<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\Serializable;
use BroadwaySerialization\Serialization\AutoSerializable;

final class SomeOtherSerializableClassUsingTrait implements Serializable
{
    use AutoSerializable;

    private $foo;

    public function __construct($foo)
    {
        $this->foo = $foo;
    }
}
