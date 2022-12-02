<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Cats\Maybe;

use j45l\functional\Cats\Maybe\Maybe;
use j45l\functional\Cats\Maybe\None;
use j45l\functional\Cats\Maybe\Some;
use PHPUnit\Framework\TestCase;

use function j45l\functional\Cats\Maybe\Maybe;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/**
 * @covers ::\j45l\functional\Optional\Optional()
 * @covers \j45l\functional\Cats\Maybe\Maybe
 */
final class MaybeTest extends TestCase
{
    public function testCreatingFromNonNullOf(): void
    {
        $some = Maybe::of(42);

        assertInstanceOf(Some::class, $some);
        assertEquals(42, $some->get());
    }

    public function testCreatingFromNonNullOfNullable(): void
    {
        $some = Maybe(42);

        assertInstanceOf(Some::class, $some);
        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        assertEquals(42, $some->get());
    }

    public function testCreatingFromNullOfNullable(): void
    {
        assertInstanceOf(None::class, Maybe(null));
    }
}
