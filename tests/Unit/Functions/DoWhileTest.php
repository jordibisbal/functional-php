<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\delay;
use function j45l\functional\doUntil;
use function j45l\functional\doWhile;
use function j45l\functional\falseFn;
use function j45l\functional\nop;
use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertNull;

/** @covers ::\j45l\functional\doWhile() */
class DoWhileTest extends TestCase
{
    public function testDoWhileCanExecuteZeroTimes(): void
    {
        $effect = null;

        assertNull(
            doWhile(
                falseFn(...),
                function () use (&$effect) {
                    $effect = 42;
                }
            )
        );
        assertNull($effect);
    }

    public function testDoWhileReturnsTheEvaluationOfTheReturnFunction(): void
    {
        assertEquals(
            42,
            doWhile(falseFn(...), nop(...), fn () => 42)
        );
    }

    public function testDoUntilRepeatsWhileThePredicateIsTrue(): void
    {
        $times = 0;
        $effect = 0;

        assertEquals(
            42,
            doWhile(
                function () use (&$times): bool {
                    return $times !== 5;
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
            doWhile(
                function () use (&$times): bool {
                    return $times !== 5;
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
