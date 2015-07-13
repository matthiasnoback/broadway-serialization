<?php

namespace BroadwaySerialization\SymfonyIntegration;

use BroadwaySerialization\Reconstitution\Reconstitution;
use BroadwaySerialization\SymfonyIntegration\DependencyInjection\BroadwaySerializationExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BroadwaySerializationBundle extends Bundle
{
    public function getContainerExtension()
    {
        return new BroadwaySerializationExtension();
    }

    public function boot()
    {
        Reconstitution::reconstituteUsing($this->container->get('broadway_serialization.reconstitute'));
    }
}
