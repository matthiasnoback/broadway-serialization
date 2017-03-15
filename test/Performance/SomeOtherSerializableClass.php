<?php

namespace BroadwaySerialization\Test\Performance;

use Broadway\Serializer\Serializable;

class SomeOtherSerializableClass implements Serializable
{
    private $foo;

    public static function deserialize(array $data)
    {
        return new self($data['foo']);
    }

    public function serialize()
    {
        return [
            'foo' => $this->foo
        ];
    }

    public function __construct($foo)
    {
        $this->foo = $foo;
    }
}
