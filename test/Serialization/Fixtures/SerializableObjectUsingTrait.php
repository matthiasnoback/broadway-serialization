<?php

namespace BroadwaySerialization\Test\Serialization\Fixtures;

use Broadway\Serializer\SerializableInterface;

class SerializableObjectUsingTrait implements SerializableInterface
{
    use \BroadwaySerialization\Serialization\Serializable;

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
            'bar' => ['BroadwaySerialization\Test\Serialization\Fixtures\TraditionalSerializableObject', 'deserialize'],
            'bars' => ['BroadwaySerialization\Test\Serialization\Fixtures\TraditionalSerializableObject', 'deserialize']
        ];
    }
}
