<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use j45l\functional\Cats\Either\Failure;
use j45l\functional\Cats\Either\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Cats\Either\BecauseException;
use function j45l\functional\Cats\Either\DoTry;
use function j45l\functional\Cats\Either\isFailure;
use function j45l\functional\Cats\Either\isSuccess;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

/** @covers \j45l\functional\Cats\Either\Either */
final class EitherTest extends TestCase
{
    public function testCreatingFromNonExceptioningCallable(): void
    {
        /** @var Success<mixed,int> $success */
        $success = DoTry(static fn() => 42);

        assertTrue(isSuccess($success));
        assertEquals(42, $success->get());
    }

    public function testCreatingFromExceptioningCallable(): void
    {
        /** @var Failure<mixed,mixed> $try */
        $try = DoTry(static fn () => throw new RuntimeException('Exception'));

        self::assertTrue(isFailure($try));
        assertEquals(BecauseException(new RuntimeException('Exception')), $try->reason());
    }
}
