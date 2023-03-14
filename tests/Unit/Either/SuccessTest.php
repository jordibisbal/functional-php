<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Cats\Either\Because;
use function j45l\functional\Cats\Either\BecauseException;
use function j45l\functional\Cats\Either\Failure;
use function j45l\functional\Cats\Either\Success;
use function PHPUnit\Framework\assertEquals;

/** @covers \j45l\functional\Cats\Either\Success */
final class SuccessTest extends TestCase
{
    public function testOrElseFromSuccess(): void
    {
        assertEquals(Success(42), Success(42)->orElse(fn () => 1));
    }

    public function testSuccessAndThenFailure(): void
    {
        assertEquals(
            Failure(Because('Failed')),
            Success(42)->andThen(fn () => Failure(Because('Failed')))
        );
    }

    public function testSuccessAndThenException(): void
    {
        assertEquals(
            Failure(BecauseException(new RuntimeException('boom'))),
            Success(42)->andThen(fn () => throw new RuntimeException('boom'))
        );
    }

    public function testSuccessAndThenSuccess(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn () => Success(42))
        );
    }

    public function testSuccessAndThenNotEither(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn () => 42)
        );
    }

    public function testSuccessAndThenIncrementSuccess(): void
    {
        assertEquals(
            Success(42),
            Success(1)->andThen(fn ($x) => Success($x + 41))
        );
    }
}
