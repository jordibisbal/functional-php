<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\not;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

/** @covers ::\j45l\functional\not() */
class NotTest extends TestCase
{
    public function testNotNegates(): void
    {
        assertTrue(not(fn () => false)());
        assertFalse(not(fn() => true)());
    }
}
