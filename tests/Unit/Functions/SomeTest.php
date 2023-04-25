<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\some;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversFunction('j45l\functional\some')]
class SomeTest extends TestCase
{
    public function testTrueIfAllTrue(): void
    {
        assertTrue(some([1, 3, 5], fn ($x) => $x % 2 === 1));
    }

    public function testTrueIfSomeTrue(): void
    {
        assertTrue(some([1, 3, 5], fn ($x) => $x > 3));
    }

    public function testFalseIfAllFalse(): void
    {
        assertFalse(some([1, 3, 5], fn ($x) => $x % 2 === 0));
    }
}
