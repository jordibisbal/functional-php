<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\last;
use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

/** @covers ::\j45l\functional\last() */
class LastTest extends TestCase
{
    public function testLastReturnsLastMatching(): void
    {
        assertEquals(1, last([1, 2, 3], fn (int $x): bool => $x === 1));
        assertEquals(2, last([1, 2, 3], fn (int $x): bool => $x === 2));
        assertEquals(3, last([1, 2, 3], fn (int $x): bool => $x === 3));
        assertEquals(3, last([1, 2, 3], fn (int $x): bool => $x > 1));
    }

    public function testLastReturnsNullIfNoMatching(): void
    {
        assertEquals(null, last([1, 2, 3], fn (int $x): bool => $x === 4));
    }

    public function testLastReturnsDefaultIfStatedDefaultAndNoMatching(): void
    {
        assertEquals('default', last([1, 2, 3], fn (int $x): bool => $x === 4, 'default'));
    }

    public function testLastReturnsNullIfNoStatedDefaultAndNoMatching(): void
    {
        /** @phpstan-ignore-next-line */
        assertNull(last([1, 2, 3], fn (int $x): bool => $x === 4));
    }

    public function testLastReturnsLastIfNoPredicate(): void
    {
        assertEquals(3, last([1, 2, 3]));
    }


    public function testLastReturnsNullIfNoElements(): void
    {
        assertNull(last([]));
    }

    public function testLastReturnsDefaultIfNoElementsAndDefaultStated(): void
    {
        assertEquals('default', last([], trueFn(...), 'default'));
    }
}
