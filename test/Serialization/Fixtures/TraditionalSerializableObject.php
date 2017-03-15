<?php

namespace BroadwaySerialization\Test\Serialization\Fixtures;

use Broadway\Serializer\Serializable;

class TraditionalSerializableObject implements Serializable
{
    private $bar;

    public function __construct($value)
    {
        $this->bar = $value;
    }

    public function getBar()
    {
        return $this->bar;
    }

    public static function deserialize(array $data)
    {
        return new self($data['bar']);
    }

    public function serialize()
    {
        return ['bar' => $this->bar];
    }
}
