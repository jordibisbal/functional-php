<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Either;

use j45l\functional\Cats\Maybe\None;
use PHPUnit\Framework\TestCase;

use function j45l\functional\Cats\Either\Because;
use function j45l\functional\Cats\Either\Failure;
use function j45l\functional\Cats\Either\Success;
use function j45l\functional\Cats\Maybe\Some;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

final class EitherMaybeTest extends TestCase
{
    public function testAndThenFromSuccess(): void
    {
        assertEquals(Some(42), Success(42)->toMaybe());
    }

    public function testAndThenFromFailure(): void
    {
        assertInstanceOf(None::class, Failure(Because('Yes'))->toMaybe());
    }
}
