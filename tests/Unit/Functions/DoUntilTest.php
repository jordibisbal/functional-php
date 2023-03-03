<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\doUntil;
use function j45l\functional\nop;
use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;

/** @covers ::\j45l\functional\doUntil() */
class DoUntilTest extends TestCase
{
    public function testDoUntilExecutedAtLeastOnce(): void
    {
        $effect = null;

        assertNull(
            doUntil(
                trueFn(...),
                function () use (&$effect) {
                    $effect = 42;
                }
            )
        );
        assertEquals(42, $effect);
    }

    public function testDoUntilReturnsTheEvaluationOfTheReturnFunction(): void
    {
        assertEquals(
            42,
            doUntil(trueFn(...), nop(...), fn () => 42)
        );
    }

    public function testDoUntilRepeatsUntilThePredicateIsTrue(): void
    {
        $times = 0;
        $effect = 0;

        assertEquals(
            42,
            doUntil(
                function () use (&$times): bool {
                    /** @phpstan-ignore-next-line  */
                    return $times === 5;
                },
                function () use (&$effect, &$times) {
                    $times++;
                    $effect++;
                },
                fn () => 42
            )
        );
        assertEquals(5, $effect);
    }

    public function testDoUntilDoesNotEvaluateForLastIteration(): void
    {
        $times = 0;
        $effect = false;

        assertEquals(
            42,
            doUntil(
                function () use (&$times): bool {
                    /** @phpstan-ignore-next-line  */
                    return $times === 5;
                },
                function () use (&$effect, &$times) {
                    $effect = $effect || $times === 5;
                    $times++;
                },
                fn () => 42
            )
        );
        assertFalse($effect);
    }
}
