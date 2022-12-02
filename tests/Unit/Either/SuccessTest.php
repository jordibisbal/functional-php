<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use PHPUnit\Framework\TestCase;

use function j45l\functional\Either\Success;
use function PHPUnit\Framework\assertEquals;

/** @covers \j45l\functional\Either\Success */
final class SuccessTest extends TestCase
{
    public function testOrElseFromSuccess(): void
    {
        assertEquals(Success(42), Success(42)->orElse(fn () => 1));
    }

    public function testOrElseTryFromSuccess(): void
    {
        assertEquals(Success(42), Success(42)->orElseTry(fn () => 1));
    }
}
