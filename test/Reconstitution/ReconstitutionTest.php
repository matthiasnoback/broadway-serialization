<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Reconstitution;

use BroadwaySerialization\Reconstitution\Reconstitute;
use BroadwaySerialization\Reconstitution\Reconstitution;
use PHPUnit\Framework\TestCase;
use LogicException;

final class ReconstitutionTest extends TestCase
{
    /**
     * @test
     */
    public function it_gives_a_nice_warning_if_no_reconstitute_object_was_provided()
    {
        $this->expectException(LogicException::class);

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
        return $this->createMock(Reconstitute::class);
    }
}
