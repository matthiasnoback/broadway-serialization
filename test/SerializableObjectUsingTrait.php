<?php

namespace BroadwaySerialization\Test;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serializable;

class SerializableObjectUsingTrait implements SerializableInterface
{
    use Serializable;

    private $foo;
    private $bar;
    private $bars;

    public function __construct($foo, TraditionalSerializableObject $bar, array $bars)
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->bars = $bars;
    }

    protected static function deserializationCallbacks()
    {
        return [
            'bar' => ['\BroadwaySerialization\Test\TraditionalSerializableObject', 'deserialize'],
            'bars' => ['\BroadwaySerialization\Test\TraditionalSerializableObject', 'deserialize']
        ];
    }
}
