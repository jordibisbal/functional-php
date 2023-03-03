<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use ArrayIterator;
use PHPUnit\Framework\TestCase;

use function j45l\functional\select;
use function j45l\functional\sum;
use function PHPUnit\Framework\assertEquals;

/** @covers ::\j45l\functional\sum() */
class SumTest extends TestCase
{
    public function testSumSums(): void
    {
        assertEquals(42, sum([39, 2, 1]));
    }

    public function testEmptyReturnsZero(): void
    {
        assertEquals(0, sum([]));
    }

    public function testMixedElementsCast(): void
    {
        assertEquals(42.0, sum([39.1, 2, 0.9]));
        assertEquals(42, sum([1, 2, '39']));
    }
}
