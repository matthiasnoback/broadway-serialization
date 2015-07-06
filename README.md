# Broadway Serialization helper library

By Matthias Noback

[![Build Status](https://travis-ci.org/matthiasnoback/broadway-serialization.svg?branch=master)](https://travis-ci.org/matthiasnoback/broadway-serialization) [![Coverage Status](https://coveralls.io/repos/matthiasnoback/broadway-serialization/badge.svg?branch=master)](https://coveralls.io/r/matthiasnoback/broadway-serialization?branch=master)

Event-sourcing framework [Broadway](https://github.com/qandidate-labs/broadway)
requires a lot of your objects (like domain events and often view models as 
well) to be serializable because they have to be stored in plain text and later 
be reconstituted.

Making an object serializable requires you to write lots of pretty simple code.
Even though that code is simple, you are likely to make mistakes in it. It's 
also a bit boring to write. To alleviate the pain, this library helps you to 
make objects serializable with in a few simple steps.

## Installation

Just run

    composer require matthiasnoback/broadway-serialization

## Conventions

This library is very simple and it *just works* because of a few simple and 
yet assumptions:

1. Serializable objects have at least one property. Properties can have any 
kind of scope.
2. Serializable objects implements Broadway's `SerializableInterface`.
3. Properties contain scalar values, serializable objects, or arrays of 
serializable objects.

## Example

```php

use Broadway\Serializer\SerializableInterface;
use BroadwaySerialization\Serializable;

class SerializableObject implements SerializableInterface
{
    use Serializable;

    /**
     * @var string
     */
    private $foo;
    
    /**
     * @var SerializableObject
     */
    private $bar;
    
    /**
     * @var SerializableObject[]
     */
    private $bars = [];

    protected static function deserializationCallbacks()
    {
        return [
            'bar' => ['SerializableObject', 'deserialize'],
            'bars' => ['SerializableObject', 'deserialize']
        ];
    }
}
```

By implementing `deserializationCallbacks()` you can define callables that 
should be called in order to deserialize the provided data. The callable will 
be called once for single values or multiple times for arrays of values.
