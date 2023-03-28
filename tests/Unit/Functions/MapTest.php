<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\map;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\map')]
class MapTest extends TestCase
{
    public function testAllMapped(): void
    {
        $mappedTimes = 0;
        $map = function ($item) use (&$mappedTimes) {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        assertEquals(['a' => 'A', 'b' => 'B', 'c' => 'C'], map(['a' => 1, 'b' => 2, 'c' => 3], $map));
        assertEquals(3, $mappedTimes);
    }

    public function testMapEmpty(): void
    {
        $mappedTimes = 0;
        $map = function (int $item) use (&$mappedTimes): string {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        assertEquals([], map([], $map));
        assertEquals(0, $mappedTimes);
    }
}
