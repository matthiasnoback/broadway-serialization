<?php

namespace BroadwaySerialization\Test\Reconstitution;

use BroadwaySerialization\Reconstitution\Reconstitution;

class ReconstitutionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_gives_a_nice_warning_if_no_reconstitute_object_was_provided()
    {
        $this->setExpectedException('\LogicException');

        Reconstitution::reconstitute();
    }

    /**
     * @test
     */
    public function it_returns_the_previously_provided_reconstitute_object()
    {
        $reconstitute = $this->dummyReconstitute();
        Reconstitution::reconstituteUsing($reconstitute);

        $this->assertSame($reconstitute, Reconstitution::reconstitute());
    }

    private function dummyReconstitute()
    {
        return $this->getMock('BroadwaySerialization\Reconstitution\Reconstitute');
    }
}
