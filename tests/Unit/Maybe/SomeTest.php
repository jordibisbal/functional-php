<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Maybe;

use PHPUnit\Framework\TestCase;

use function j45l\functional\Either\Success;
use function j45l\functional\Maybe\Some;
use function PHPUnit\Framework\assertEquals;

/** @covers \j45l\functional\Maybe\Some */
final class SomeTest extends TestCase
{
    public function testOrElseFromSome(): void
    {
        assertEquals(Some(42), Some(42)->orElse(fn() => 1));
    }

    public function testGetOrElseFromSome(): void
    {
        assertEquals(42, Some(42)->getOrElse(1));
    }

    public function testGetOrFailsReturnsValue(): void
    {
        assertEquals(42, Some(42)->getOrFail());
    }

    public function testAndThenFromSome(): void
    {
        assertEquals(Some(42), Some(1)->andThen(fn () => 42));
    }

    public function testAndThenTryFromSome(): void
    {
        assertEquals(Success(42), Some(1)->andThenTry(fn () => 42));
    }

    public function testMapFromSome(): void
    {
        assertEquals(Some(42), Some(21)->map(fn ($x) => $x * 2));
    }
}
