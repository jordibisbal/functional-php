<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\first;
use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

/** @covers ::\j45l\functional\first() */
class FirstTest extends TestCase
{
    public function testFirstReturnsFirstMatching(): void
    {
        assertEquals(1, first([1, 2, 3], fn (int $x): bool => $x === 1));
        assertEquals(2, first([1, 2, 3], fn (int $x): bool => $x === 2));
        assertEquals(3, first([1, 2, 3], fn (int $x): bool => $x === 3));
        assertEquals(2, first([1, 2, 3], fn (int $x): bool => $x > 1));
    }

    public function testFirstReturnsNullIfNoMatching(): void
    {
        assertEquals(null, first([1, 2, 3], fn (int $x): bool => $x === 4));
    }

    public function testFirstReturnsDefaultIfStatedDefaultAndNoMatching(): void
    {
        assertEquals('default', first([1, 2, 3], fn (int $x): bool => $x === 4, 'default'));
    }

    public function testFirstReturnsNullIfNoStatedDefaultAndNoMatching(): void
    {
        /** @phpstan-ignore-next-line */
        assertNull(first([1, 2, 3], fn (int $x): bool => $x === 4));
    }

    public function testFirstReturnsFirstIfNoPredicate(): void
    {
        assertEquals(1, first([1, 2, 3]));
    }


    public function testFirstReturnsNullIfNoElements(): void
    {
        assertNull(first([]));
    }

    public function testFirstReturnsDefaultIfNoElementsAndDefaultStated(): void
    {
        assertEquals('default', first([], trueFn(...), 'default'));
    }
}
