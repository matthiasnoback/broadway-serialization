<?php

namespace BroadwaySerialization\Test;

use BroadwaySerialization\OcramiusReconstitute;
use Doctrine\Instantiator\Instantiator;

class OcramiusReconstituteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_reconstitutes_a_serialized_object()
    {
        $reconstitute = new OcramiusReconstitute(new Instantiator(), sys_get_temp_dir());

        $className = 'BroadwaySerialization\Test\TraditionalSerializableObject';
        $data = ['bar' => 'baz'];
        $object = $reconstitute->objectFrom($className, $data);

        $this->assertInstanceOf($className, $object);
        $this->assertSame($data['bar'], $object->getBar());
    }
}
