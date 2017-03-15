<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Hydrate\Fixtures;

final class ClassWithPrivateProperties
{
    private $foo;

    public function foo()
    {
        return $this->foo;
    }
}
