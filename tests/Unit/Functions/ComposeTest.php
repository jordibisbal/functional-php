<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\compose;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\compose')]
class ComposeTest extends TestCase
{
    public function testEmptyComposeReturnsIdentity(): void
    {
        assertEquals(42, compose()(42));
    }

    public function testEmptyComposeCanBeCalledWithOutParameters(): void
    {
        assertEquals(42, compose(fn () => 42)());
    }

    public function testSingleComposeEvaluation(): void
    {
        assertEquals(42, compose(fn ($x) => $x + 1)(41));
    }

    public function testComposeEvaluatesFromLeftToRight(): void
    {
        assertEquals(
            42,
            compose(
                fn ($x) => $x * 10,
                fn ($x) => $x + 2,
            )(4)
        );
    }
}
