<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use j45l\functional\Cats\DoTry\Failure;
use j45l\functional\Cats\DoTry\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Cats\DoTry\BecauseException;
use function j45l\functional\Cats\DoTry\DoTry;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/** @covers \j45l\functional\Cats\DoTry\DoTry */
final class EitherTest extends TestCase
{
    public function testCreatingFromNonExceptioningCallable(): void
    {
        /** @var Success<int> $success */
        $success = DoTry(static fn() => 42);

        assertInstanceOf(Success::class, $success);
        assertEquals(42, $success->get());
    }

    public function testCreatingFromExceptioningCallable(): void
    {
        /** @var Failure<mixed> $try */
        $try = DoTry(static fn () => throw new RuntimeException('Exception'));

        assertInstanceOf(Failure::class, $try);
        assertEquals(BecauseException(new RuntimeException('Exception')), $try->reason());
    }
}
