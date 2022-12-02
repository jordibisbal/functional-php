<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Maybe;

use j45l\functional\Cats\Either\Reason\BecauseException;
use j45l\functional\Either\Failure;
use j45l\functional\Either\Success;
use j45l\functional\Maybe\None;
use j45l\functional\Maybe\Some;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use function j45l\functional\Either\BecauseNull;
use function j45l\functional\Either\Failure;
use function j45l\functional\Maybe\None;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/** @covers \j45l\functional\Maybe\None */
/** @covers \j45l\functional\Maybe\Some */
final class OptionalTryTest extends TestCase
{
    public function testOrElseTryFromNone(): void
    {
        assertEquals(Success::pure(42), None::create()->orElseTry(fn () => 42));
    }

    public function testOrElseTryFromSome(): void
    {
        assertEquals(Success::pure(42), Some::pure(42)->orElseTry(fn () => 1));
    }

    public function testOrElseFailingTryFromNone(): void
    {
        /** @var Failure<mixed> $failure */
        $failure = None::create()->orElseTry(fn() => throw new RuntimeException('exception'));

        assertInstanceOf(Failure::class, $failure);
        assertEquals(BecauseException::of(new RuntimeException('exception')), $failure->reason);
    }

    public function testOrElseFailingTryFromSome(): void
    {
        assertEquals(
            Success::pure(42),
            Some::pure(42)->orElseTry(fn () => throw new RuntimeException('exception'))
        );
    }

    public function testAndThenTryFromNone(): void
    {
        assertEquals(Failure(BecauseNull()), None()->andThenTry(fn () => 42));
    }
}
