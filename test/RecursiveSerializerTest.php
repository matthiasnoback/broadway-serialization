<?php

namespace BroadwaySerialization\Test;

use BroadwaySerialization\RecursiveSerializer;

class RecursiveSerializerTest extends \PHPUnit_Framework_TestCase
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
}
