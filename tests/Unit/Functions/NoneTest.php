<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\none;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

#[CoversFunction('j45l\functional\none')]
class NoneTest extends TestCase
{
    public function testFalseIfAllTrue(): void
    {
        assertFalse(none([1, 3, 5], fn ($x) => $x % 2 === 1));
    }

    public function testFalseIfSomeTrue(): void
    {
        assertFalse(none([1, 3, 5], fn ($x) => $x !== 3));
    }

    public function testTrueIfAllFalse(): void
    {
        assertTrue(none([1, 3, 5], fn ($x) => $x % 2 === 0));
    }
}
