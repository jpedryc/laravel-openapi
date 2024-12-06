<?php

namespace Vyuldashev\LaravelOpenApi\Tests;

use Vyuldashev\LaravelOpenApi\Tests\Fixtures\ExampleSchema;

class MemoizationTest extends TestCase
{
    public function testReferencableInstanceBuildOnce(): void
    {
        self::assertEquals($e1ObjectId = (new ExampleSchema)::ref('e1'), (new ExampleSchema)::ref('e1'));
        self::assertNotEquals($e1ObjectId, (new ExampleSchema)::ref('e2'));
    }
}
