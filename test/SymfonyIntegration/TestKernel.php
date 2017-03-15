<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\SymfonyIntegration;

use BroadwaySerialization\SymfonyIntegration\BroadwaySerializationBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

final class TestKernel extends Kernel
{
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }

    public function registerBundles(): array
    {
        return [
            new BroadwaySerializationBundle()
        ];
    }
}
