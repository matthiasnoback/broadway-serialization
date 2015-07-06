<?php

namespace BroadwaySerialization\Test\Hydrate\Fixtures;

class ClassWithPrivateProperties
{
    private $foo;

    public function foo()
    {
        return $this->foo;
    }
}
