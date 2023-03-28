<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\concat;
use function j45l\functional\partialRight;
use function j45l\functional\sum;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\partialRight')]
class PartialRightTest extends TestCase
{
    public function testPartialWithNoArguments(): void
    {
        assertEquals(42, partialRight(static fn ($x, $y) => $x + $y)(41, 1));
    }

    public function testPartialWithOneArguments(): void
    {
        assertEquals(42, partialRight(static fn ($x, $y) => $x + $y, 1)(41));
    }

    public function testPartialWithTwoArguments(): void
    {
        assertEquals(42, partialRight(static fn ($x, $y, $z) => $x + $y + $z, 1, 3)(38));
    }

    public function testPartialWithTwoAndTwoArguments(): void
    {
        assertEquals(42, partialRight(static fn (...$values) => sum($values), 1, 3)(33, 5));
    }

    public function testPartialIsFromLeft(): void
    {
        assertEquals(
            'abcd',
            partialRight(static fn (...$values) => concat($values), 'c', 'd')('a', 'b')
        );
    }
}
