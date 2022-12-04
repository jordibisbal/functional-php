<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Cats\Maybe;

use j45l\functional\Cats\Either\Failure;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Cats\Either\BecauseException;
use function j45l\functional\Cats\Either\BecauseNull;
use function j45l\functional\Cats\Either\Failure;
use function j45l\functional\Cats\Either\Success;
use function j45l\functional\Cats\Maybe\None;
use function j45l\functional\Cats\Maybe\Some;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/** @covers \j45l\functional\Cats\Maybe\None */
/** @covers \j45l\functional\Cats\Maybe\Some */
final class OptionalTryTest extends TestCase
{
    public function testTryFromNone(): void
    {
        assertEquals(Success(42), None()->orElseTry(fn () => 42));
    }

    public function testTryFromSome(): void
    {
        assertEquals(Success(42), Some(1)->try(fn () => 42));
    }

    public function testOrElseFailingTryFromNone(): void
    {
        /** @var Failure<mixed> $failure */
        $failure = None()->orElseTry(fn() => throw new RuntimeException('exception'));

        assertInstanceOf(Failure::class, $failure);
        assertEquals(BecauseException(new RuntimeException('exception')), $failure->reason);
    }

    public function testOrElseFailingTryFromSome(): void
    {
        assertEquals(
            Failure(BecauseException(new RuntimeException('exception'))),
            Some(1)->try(fn () => throw new RuntimeException('exception'))
        );
    }

    public function testAndThenTryFromNone(): void
    {
        assertEquals(Failure(BecauseNull()), None()->andThenTry(fn () => 42));
    }
}
