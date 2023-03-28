<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\toIterable;
use function j45l\functional\yieldIterable;

#[CoversFunction('j45l\functional\toIterable')]
class ToIterableTest extends TestCase
{
    public function testToArray(): void
    {
        $this->assertEquals([1], toIterable(1));
        $this->assertEquals([1, 2, 3], toIterable([1, 2, 3]));
        $this->assertEquals(yieldIterable([1, 2, 3]), toIterable(yieldIterable([1, 2, 3])));
    }
}
