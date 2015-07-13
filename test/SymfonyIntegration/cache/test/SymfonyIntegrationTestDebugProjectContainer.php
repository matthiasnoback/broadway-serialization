<?php

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InactiveScopeException;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * SymfonyIntegrationTestDebugProjectContainer.
 *
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 */
class SymfonyIntegrationTestDebugProjectContainer extends Container
{
    private $parameters;
    private $targetDirs = array();

    /**
     * Constructor.
     */
    public function __construct()
    {
        $dir = __DIR__;
        for ($i = 1; $i <= 5; ++$i) {
            $this->targetDirs[$i] = $dir = dirname($dir);
        }
        $this->parameters = $this->getDefaultParameters();

        $this->services =
        $this->scopedServices =
        $this->scopeStacks = array();
        $this->scopes = array();
        $this->scopeChildren = array();
        $this->methodMap = array(
            'broadway_serialization.reconstitute' => 'getBroadwaySerialization_ReconstituteService',
        );

        $this->aliases = array();
    }

    /**
     * {@inheritdoc}
     */
    public function compile()
    {
        throw new LogicException('You cannot compile a dumped frozen container.');
    }

    /**
     * Gets the 'broadway_serialization.reconstitute' service.
     *
     * This service is shared.
     * This method always returns the same instance of the service.
     *
     * @return \BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator A BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator instance.
     */
    protected function getBroadwaySerialization_ReconstituteService()
    {
        return $this->services['broadway_serialization.reconstitute'] = new \BroadwaySerialization\Reconstitution\ReconstituteUsingInstantiatorAndHydrator(new \Doctrine\Instantiator\Instantiator(), new \BroadwaySerialization\Hydration\HydrateUsingReflection());
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter($name)
    {
        $name = strtolower($name);

        if (!(isset($this->parameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasParameter($name)
    {
        $name = strtolower($name);

        return isset($this->parameters[$name]) || array_key_exists($name, $this->parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    /**
     * {@inheritdoc}
     */
    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $this->parameterBag = new FrozenParameterBag($this->parameters);
        }

        return $this->parameterBag;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'kernel.root_dir' => $this->targetDirs[2],
            'kernel.environment' => 'test',
            'kernel.debug' => true,
            'kernel.name' => 'SymfonyIntegration',
            'kernel.cache_dir' => __DIR__,
            'kernel.logs_dir' => ($this->targetDirs[2].'/logs'),
            'kernel.bundles' => array(
                'BroadwaySerializationBundle' => 'BroadwaySerialization\\SymfonyIntegration\\BroadwaySerializationBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'SymfonyIntegrationTestDebugProjectContainer',
        );
    }
}
