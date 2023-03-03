<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\butLast;
use function PHPUnit\Framework\assertEquals;

/** @covers ::\j45l\functional\butLast() */
class ButLastTest extends TestCase
{
    public function testEmptyArray(): void
    {
        assertEquals([], butLast([]));
    }

    public function testSingleElementArray(): void
    {
        assertEquals([], butLast([1]));
    }

    public function testTwoElementArray(): void
    {
        assertEquals([1], butLast([1, 2]));
    }

    public function testMultipleElementArray(): void
    {
        assertEquals([1, 2], butLast([1, 2, 3]));
    }
}
