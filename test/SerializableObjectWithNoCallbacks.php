<?php

namespace BroadwaySerialization\Test;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serializable;

class SerializableObjectWithNoCallbacks implements SerializableInterface
{
    use Serializable;

    private $bar;

    public function __construct($bar)
    {
        $this->bar = $bar;
    }
}
