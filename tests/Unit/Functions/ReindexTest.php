<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\reindex;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\reindex')]
class ReindexTest extends TestCase
{
    public function testAllMapped(): void
    {
        $mappedTimes = 0;
        $reindex = function ($key) use (&$mappedTimes) {
            $mappedTimes++;

            return ['a' => 'A', 'b' => 'B', 'c' => 'C'][$key];
        };

        assertEquals(['A' => 1, 'B' => 2, 'C' => 3], reindex(['a' => 1, 'b' => 2, 'c' => 3], $reindex));
        assertEquals(3, $mappedTimes);
    }

    public function testMapEmpty(): void
    {
        $mappedTimes = 0;
        $map = function (int $item) use (&$mappedTimes): string {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        assertEquals([], reindex([], $map));
        assertEquals(0, $mappedTimes);
    }
}
