<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use Closure;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function array_values as arrayValues;
use function j45l\functional\flatMap;
use function j45l\functional\map;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\map')]
class FlatMapTest extends TestCase
{
    public function testAllMapped(): void
    {
        $mappedTimes = 0;
        $map = function ($item) use (&$mappedTimes) {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        assertEquals(['A', 'B', 'C'], flatMap(['a' => 1, 'b' => 2, 'c' => 3], $map));
        assertEquals(3, $mappedTimes);
    }

    public function testNullsDiscarded(): void
    {
        $mappedTimes = 0;

        assertEquals(
            ['A', 'B1', 'B2', 'C'],
            flatMap(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $this->mapper($mappedTimes))
        );
        assertEquals(4, $mappedTimes);
    }

    public function testKeysDiscarded(): void
    {
        $mappedTimes = 0;

        assertEquals(
            arrayValues(flatMap(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $this->mapper($mappedTimes))),
            flatMap(['a' => 1, 'b' => 2, 'c' => 3, 'd' => 4], $this->mapper($mappedTimes))
        );
        assertEquals(4, $mappedTimes);
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

    /**
     * @return Closure(int, int|string, iterable<int>):(string|string[]|null)
     */
    private function mapper(int &$mappedTimes): Closure
    {
        return static function (int $item) use (&$mappedTimes): null|string|array {
            $mappedTimes++;

            return [1 => 'A', 2 => [21 => 'B1', 22 => 'B2'], 3 => 'C', 4 => null][$item];
        };
    }
}
