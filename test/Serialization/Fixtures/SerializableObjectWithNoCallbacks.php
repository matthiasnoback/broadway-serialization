<?php

namespace BroadwaySerialization\Test\Serialization\Fixtures;

use Broadway\Serializer\Serializable;
use BroadwaySerialization\Serialization\AutoSerializable;

class SerializableObjectWithNoCallbacks implements Serializable
{
    use AutoSerializable;

    private $bar;

    public function __construct($bar)
    {
        $this->bar = $bar;
    }
}
