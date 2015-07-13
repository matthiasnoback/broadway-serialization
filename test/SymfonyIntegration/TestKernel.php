<?php

namespace BroadwaySerialization\Test\SymfonyIntegration;

use BroadwaySerialization\SymfonyIntegration\BroadwaySerializationBundle;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class TestKernel extends Kernel
{
    public function registerContainerConfiguration(LoaderInterface $loader)
    {
    }

    public function registerBundles()
    {
        return [
            new BroadwaySerializationBundle()
        ];
    }
}
