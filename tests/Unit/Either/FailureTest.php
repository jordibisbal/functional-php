<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use PHPUnit\Framework\TestCase;
use RuntimeException;

use function j45l\functional\Cats\Either\Because;
use function j45l\functional\Cats\Either\Failure;
use function j45l\functional\Cats\Either\Success;
use function j45l\functional\Cats\Maybe\None;
use function PHPUnit\Framework\assertEquals;

final class FailureTest extends TestCase
{
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

    public function testOrElseSuccessFromFailure(): void
    {
        assertEquals(Success(42), Failure(Because('whatever'))->orElse(fn () => Success(42)));
    }

    public function testOrElseWrapsInSuccessFromFailure(): void
    {
        assertEquals(
            Success(Failure(Because('whatever'))),
            Failure(Because('whatever'))->orElse(fn ($x) => Success($x))
        );
    }
}
