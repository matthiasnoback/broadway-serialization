<?php namespace BroadwaySerialization\Test\Hydrate;

use BroadwaySerialization\Hydration\Hydrate;
use BroadwaySerialization\Test\Hydrate\Fixtures\ClassWithoutProperties;
use BroadwaySerialization\Test\Hydrate\Fixtures\ClassWithPrivateProperties;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestForHydration extends TestCase
{

    /**
     * @test
     */
    public function it_hydrates_an_object_with_private_properties()
    {
        $hydrate = $this->getHydrator();
        $object = new ClassWithPrivateProperties();
        $hydrate->hydrate(['foo' => 'bar'], $object);

        $this->assertSame('bar', $object->foo());
    }

    /**
     * @test
     */
    public function it_ignores_keys_that_are_not_defined_in_the_data_array()
    {
        $hydrate = $this->getHydrator();
        $object = new ClassWithPrivateProperties();

        // 'foo' is not defined, which should be no problem
        $hydrate->hydrate([], $object);

        $this->assertSame(null, $object->foo());
    }

    /**
     * @test
     */
    public function it_ignores_extra_keys_in_the_data_array()
    {
        $hydrate = $this->getHydrator();
        $object = new ClassWithPrivateProperties();

        // 'extra' is not a property, which should be no problem
        $hydrate->hydrate(['extra' => 'no problem', 'foo' => 'bar'], $object);

        $this->assertSame('bar', $object->foo());
    }

    /**
     * @test
     */
    public function it_works_for_objects_without_properties()
    {
        $hydrate = $this->getHydrator();
        $object = new ClassWithoutProperties();

        // This class doesn't have any property which should be no problem
        $hydrate->hydrate([], $object);

        $this->assertTrue(true); // to prevent a strict warning
    }

    /**
     * @return Hydrate
     */
    abstract protected function getHydrator();
}