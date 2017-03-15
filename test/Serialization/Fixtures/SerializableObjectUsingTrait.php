<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Serialization\Fixtures;

use Broadway\Serializer\Serializable;
use BroadwaySerialization\Serialization\AutoSerializable;

final class SerializableObjectUsingTrait implements Serializable
{
    use AutoSerializable;

    private $foo;
    private $bar;
    private $bars;

    public function __construct($foo, TraditionalSerializableObject $bar, array $bars)
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->bars = $bars;
    }

    protected static function deserializationCallbacks(): array
    {
        return [
            'bar' => [TraditionalSerializableObject::class, 'deserialize'],
            'bars' => [TraditionalSerializableObject::class, 'deserialize']
        ];
    }
}
