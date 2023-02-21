<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\mapFirst;
use function PHPUnit\Framework\assertEquals;

class MapFirstTest extends TestCase
{
    public function testFirstMapped(): void
    {
        $mappedTimes = 0;
        $map = function ($item) use (&$mappedTimes) {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        assertEquals('A', mapFirst([1, 2, 3], $map));
        assertEquals(1, $mappedTimes);
    }

    public function testFirstMappedWithPredicate(): void
    {
        $mappedTimes = 0;
        $map = function (int $item) use (&$mappedTimes): string {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        $predicate = fn(string $item): bool => $item === 'B';

        assertEquals('B', mapFirst([1, 2, 3], $map, $predicate)); /** @phpstan-ignore-line  */
        assertEquals(2, $mappedTimes);
    }

    public function testFirstMappedWithPredicateAndDefault(): void
    {
        $mappedTimes = 0;
        $map = function (int $item) use (&$mappedTimes): string {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        $predicate = fn(string $item): bool => false;

        assertEquals('D', mapFirst([1, 2, 3], $map, $predicate, 'D'));
        assertEquals(3, $mappedTimes);
    }

    public function testFirstMappedWithPredicateAndDefaultOnEmpty(): void
    {
        $mappedTimes = 0;
        $map = function (int $item) use (&$mappedTimes): string {
            $mappedTimes++;

            return [1 => 'A', 2 => 'B', 3 => 'C'][$item];
        };

        $predicate = fn(string $item): bool => false;

        assertEquals('D', mapFirst([], $map, $predicate, 'D'));
        assertEquals(0, $mappedTimes);
    }
}
