<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\every;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversFunction('j45l\functional\every')]
class EveryTest extends TestCase
{
    public function testTrueIfAllTrue(): void
    {
        assertTrue(every([1, 3, 5], fn ($x) => $x % 2 === 1));
    }

    public function testFalseIfSomeFalse(): void
    {
        assertFalse(every([1, 3, 5], fn ($x) => $x !== 3));
    }

    public function testFalseIfAllFalse(): void
    {
        assertFalse(every([1, 3, 5], fn ($x) => $x % 2 === 0));
    }

    public function testFalseIfSomeFalseBool(): void
    {
        assertFalse(every([true, true, false]));
    }

    public function testTrueIfAllTrueBool(): void
    {
        assertTrue(every([true, true, true]));
    }
}
