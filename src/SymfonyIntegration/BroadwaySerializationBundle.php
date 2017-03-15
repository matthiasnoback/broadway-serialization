<?php
declare(strict_types = 1);

namespace BroadwaySerialization\SymfonyIntegration;

use BroadwaySerialization\Reconstitution\Reconstitution;
use BroadwaySerialization\SymfonyIntegration\DependencyInjection\BroadwaySerializationExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BroadwaySerializationBundle extends Bundle
{
    public function getContainerExtension(): BroadwaySerializationExtension
    {
        return new BroadwaySerializationExtension();
    }

    public function boot()
    {
        Reconstitution::reconstituteUsing($this->container->get('broadway_serialization.reconstitute'));
    }
}
