<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\also;
use function PHPUnit\Framework\assertEquals;

/** @covers ::\j45l\functional\also() */
class AlsoTest extends TestCase
{
    public function testCanProduceEffect(): void
    {
        $effect = 20;

        assertEquals(
            22,
            also(function ($x) use (&$effect) {
                    $effect += $x;
            })(22)
        );

        assertEquals(42, $effect);
    }
}
