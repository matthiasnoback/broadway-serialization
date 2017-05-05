<?php

namespace BroadwaySerialization\Test\Hydrate;

use BroadwaySerialization\Hydration\HydrateUsingClosure;

class HydrateUsingClosureTest extends AbstractTestForHydration
{
    protected function getHydrator()
    {
        return new HydrateUsingClosure();
    }
}
