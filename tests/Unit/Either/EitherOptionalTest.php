<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use j45l\functional\Maybe\None;
use j45l\functional\Maybe\Some;
use PHPUnit\Framework\TestCase;

use function j45l\functional\Either\Because;
use function j45l\functional\Either\Failure;
use function j45l\functional\Either\Success;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;
use function j45l\functional\Maybe\Some;

final class EitherOptionalTest extends TestCase
{
    public function testAndThenFromSuccess(): void
    {
        assertEquals(Some(42), Success(1)->andThen(fn () => 42));
    }

    public function testAndThenFromFailure(): void
    {
        assertInstanceOf(None::class, Failure(Because('Yes'))->andThen(fn () => 42));
    }
}
