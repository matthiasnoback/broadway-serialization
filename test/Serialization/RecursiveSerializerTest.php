<?php
declare(strict_types = 1);

namespace BroadwaySerialization\Test\Serialization;

use BroadwaySerialization\Serialization\RecursiveSerializer;
use BroadwaySerialization\Test\Serialization\Fixtures\TraditionalSerializableObject;
use PHPUnit\Framework\TestCase;

final class RecursiveSerializerTest extends TestCase
{
    /**
     * @test
     */
    public function it_serializes_data_recursively()
    {
        $serializedData = RecursiveSerializer::serialize([
            'foo' => 'bar',
            'bar' => new TraditionalSerializableObject('bing'),
            'baz' => [
                new TraditionalSerializableObject('bang'),
                new TraditionalSerializableObject('bong')
            ]
        ]);

        $this->assertEquals(
            [
                'foo' => 'bar',
                'bar' => ['bar' => 'bing'],
                'baz' => [
                    ['bar' => 'bang'],
                    ['bar' => 'bong']
                ]
            ],
            $serializedData
        );
    }

    /**
     * @test
     */
    public function it_deserializes_data_recursively()
    {
        $serializedData = [
            'foo' => 'bar',
            'bar' => ['bar' => 'bing'],
            'baz' => [
                ['bar' => 'bang'],
                ['bar' => 'bong']
            ]
        ];

        $this->assertEquals(
            [
                'foo' => 'bar',
                'bar' => new TraditionalSerializableObject('bing'),
                'baz' => [
                    new TraditionalSerializableObject('bang'),
                    new TraditionalSerializableObject('bong')
                ]
            ],
            RecursiveSerializer::deserialize($serializedData, [
                'bar' => function(array $data) {
                    return new TraditionalSerializableObject($data['bar']);
                },
                'baz' => function(array $data) {
                    return new TraditionalSerializableObject($data['bar']);
                }
            ])
        );
    }

    /**
     * @test
     */
    public function when_serializing_it_leaves_an_array_of_scalar_values_as_it_is()
    {
        $serializedData = [
            'foo' => ['bar', 'baz']
        ];

        $this->assertSame($serializedData, RecursiveSerializer::serialize($serializedData));
    }

    /**
     * @test
     */
    public function when_deserializing_it_leaves_an_array_of_scalar_values_as_it_is()
    {
        $serializedData = [
            'foo' => ['bar', 'baz']
        ];

        $this->assertSame($serializedData, RecursiveSerializer::deserialize($serializedData));
    }

    /**
     * @test
     */
    public function when_deserializing_do_not_call_the_callable_when_the_value_is_null()
    {
        $serializedData = [
            'foo' => null
        ];
        $callables = [
            'foo' => function(array $data) {
                // when passing null, this would cause a fatal error
            }
        ];

        $this->assertSame($serializedData, RecursiveSerializer::deserialize($serializedData, $callables));
    }
}
