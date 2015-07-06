<?php

namespace BroadwaySerialization\Test\Serialization;

use BroadwaySerialization\Serialization\ArrayHelper;

class ArrayHelperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function an_empty_array_is_a_numerically_indexed_array()
    {
        $this->assertTrue(ArrayHelper::isNumericallyIndexed([]));
    }

    /**
     * @test
     */
    public function an_array_with_an_integer_key_is_numerically_indexed()
    {
        $this->assertTrue(ArrayHelper::isNumericallyIndexed([0 => 'first value']));
    }

    /**
     * @test
     */
    public function an_array_with_a_non_integer_key_is_not_numerically_indexed()
    {
        $this->assertFalse(ArrayHelper::isNumericallyIndexed(['first_key' => 'first value']));
    }
}
