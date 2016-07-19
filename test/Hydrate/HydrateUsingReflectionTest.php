<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Hydrate;

use BroadwaySerialization\Hydration\HydrateUsingReflection;

final class HydrateUsingReflectionTest extends AbstractTestForHydration
{
    protected function getHydrator()
    {
        return new HydrateUsingReflection();
    }
}
