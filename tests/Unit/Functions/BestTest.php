<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Pair;
use PHPUnit\Framework\TestCase;
use function j45l\functional\best;

class BestTest extends TestCase
{
    public function testBestOnEmptyReturnsNullWhenNoDefault(): void
    {
        $collection = [];
        $bigger = function ($first, $second): int {
            return $first <=> $second;
        };

        self::assertNull(best($collection, $bigger));
    }

    public function testBestOnEmptyReturnsDefault(): void
    {
        $collection = [];
        $bigger = function ($first, $second): int {
            return $first <=> $second;
        };

        self::assertEquals(42, best($collection, $bigger, 42));
    }

    public function testWorstReturnsWorst(): void
    {
        $collection = [Pair::from('A', 1), Pair::from('B', 2), Pair::from('C', 2), Pair::from('D', 1)];
        $bigger = function (Pair $value, Pair $initial): int {
            return $value->second() <=>  $initial->second();
        };

        self::assertEquals(2, best($collection, $bigger)->second());
    }

    public function testWorstReturnsFirstWorst(): void
    {
        $collection = [Pair::from('A', 1), Pair::from('B', 2), Pair::from('C', 2), Pair::from('D', 1)];
        $bigger = function (Pair $value, Pair $initial): int {
            return $value->second() <=>  $initial->second();
        };

        self::assertEquals('B', best($collection, $bigger)->first());
    }
}
