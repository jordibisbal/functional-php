<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use j45l\functional\Cats\Either\Success;
use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Cats\Either\Because;
use function j45l\functional\Cats\Either\Failure;
use function j45l\functional\Cats\Either\isSuccess;
use function j45l\functional\Cats\Either\Success;
use function j45l\functional\Cats\Maybe\None;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

final class FailureTest extends TestCase
{
    public function testOrElseFromFailure(): void
    {
        assertEquals(Success(42), Failure(Because('whatever'))->orElse(fn () => 42));
    }

    public function testFailureGetOrFailFails(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('getOrFail() called upon a Left object.');

        Failure(Because('yes'))->getOrFail();
    }

    public function testFailureGetOrFailWithMessageFails(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Message.');

        None()->getOrFail('Message.');
    }

    public function testOrElseTryFromFailure(): void
    {
        /** @var Success<mixed,int> $success */
        $success = Failure(Because('whatever'))->orElse(fn() => 42);

        assertTrue(isSuccess($success));
        assertEquals(42, $success->get());
    }
}
