<?php

namespace Vyuldashev\LaravelOpenApi\Tests\Fixtures;

use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Contracts\Reusable;
use Vyuldashev\LaravelOpenApi\Factories\SchemaFactory;

class ExampleSchema extends SchemaFactory implements Reusable
{
    public function build(): SchemaContract
    {
        return Schema::object('ExampleSchema')
            ->properties(
                Schema::string('example_string'),
                Schema::integer('example_integer'),
                Schema::boolean('example_boolean'),
            );
    }
}
