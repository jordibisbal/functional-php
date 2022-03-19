<?php

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\toArray;
use function j45l\functional\yieldIterable;

class ToArrayTest extends TestCase
{
    public function testToArray(): void
    {
        $this->assertEquals([1], toArray(1));
        $this->assertEquals([1, 2, 3], toArray([1, 2, 3]));
        $this->assertEquals([1, 2, 3], toArray(yieldIterable([1, 2, 3])));
    }
}
