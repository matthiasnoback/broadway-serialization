<?php

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serialization\Serializable;

class SerializableClassUsingTrait implements SerializableInterface
{
    use Serializable;

    private $stringProperty = 'foo';
    private $integerProperty = 20;
    private $nullProperty = null;
    private $arrayProperty = ['foo' => 'bar', 'bar' => 'baz'];
    private $objectProperty;
    private $objectsProperty;

    public function __construct()
    {
        $this->objectProperty = new SomeOtherSerializableClassUsingTrait('foo');
        $this->objectsProperty = [
            new SomeOtherSerializableClassUsingTrait('bar'),
            new SomeOtherSerializableClassUsingTrait('baz'),
        ];
    }

    protected static function deserializationCallbacks()
    {
        return [
            'objectProperty' => [
                SomeOtherSerializableClassUsingTrait::class,
                'deserialize'
            ],
            'objectsProperty' => [
                SomeOtherSerializableClassUsingTrait::class,
                'deserialize'
            ],
        ];
    }
}
