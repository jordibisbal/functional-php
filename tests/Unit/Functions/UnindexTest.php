<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\unindex;

/** @covers ::\j45l\functional\unindex() */
class UnindexTest extends TestCase
{
    public function testUnindexedArray(): void
    {
        $this->assertEquals([1, 2, 3], unindex([1, 2, 3]));
    }

    public function testIndexedArray(): void
    {
        $this->assertEquals([1, 2, 3], unindex(['a' => 1, 'b' => 2, 'c' => 3]));
        $this->assertEquals([1, 2, 3], unindex([1 => 1, 2 => 2, 3 => 3]));
    }
}
