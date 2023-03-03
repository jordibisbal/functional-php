<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\Tuples\Pair;
use function j45l\functional\with;
use function PHPUnit\Framework\assertEquals;

/** @covers ::\j45l\functional\with() */
final class WithTest extends TestCase
{
    public function testAppliedParametersAreApplied(): void
    {
        self::assertEquals(42, with(43, 1)(static fn($x, $y) => $x - $y));
    }

    public function testAppliedParametersAreForEverCallbackApplied(): void
    {
        $effected = null;

        $effect = static function ($x, $y) use (&$effected) {
            $effected = Pair($x, $y);
        };

        assertEquals(
            42,
            with(43, 1)(
                static fn($x, $y) => $effect($x, $y),
                static fn($x, $y) => $x - $y,
            )
        );

        assertEquals(Pair(43, 1), $effected);
    }
}
