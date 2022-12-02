<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use j45l\functional\Either\Failure;
use j45l\functional\Either\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Either\BecauseException;
use function j45l\functional\Either\Either;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/** @covers \j45l\functional\Either\DoTry */
final class EitherTest extends TestCase
{
    public function testCreatingFromNonExceptioningCallable(): void
    {
        /** @var Success<int> $success */
        $success = Either(static fn() => 42);

        assertInstanceOf(Success::class, $success);
        assertEquals(42, $success->get());
    }

    public function testCreatingFromExceptioningCallable(): void
    {
        /** @var Failure<mixed> $try */
        $try = Either(static fn () => throw new RuntimeException('Exception'));

        assertInstanceOf(Failure::class, $try);
        assertEquals(BecauseException(new RuntimeException('Exception')), $try->reason());
    }
}
