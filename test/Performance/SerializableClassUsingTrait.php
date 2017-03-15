<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\Serializable;
use BroadwaySerialization\Serialization\AutoSerializable;

final class SerializableClassUsingTrait implements Serializable
{
    use AutoSerializable;

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

    protected static function deserializationCallbacks(): array
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
