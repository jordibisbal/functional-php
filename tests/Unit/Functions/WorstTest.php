<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Pair;
use PHPUnit\Framework\TestCase;
use function j45l\functional\worst;

class WorstTest extends TestCase
{
    public function testWorstOnEmptyReturnsNullWhenNoDefault(): void
    {
        $collection = [];
        $bigger = function ($first, $second): int {
            return $first <=> $second;
        };

        self::assertNull(worst($collection, $bigger));
    }

    public function testWorstOnEmptyReturnsDefault(): void
    {
        $collection = [];
        $bigger = function ($first, $second): int {
            return $first <=> $second;
        };

        self::assertEquals(42, worst($collection, $bigger, 42));
    }

    public function testWorstReturnsWorst(): void
    {
        $collection = [Pair::from(1, 1), Pair::from(2, 2), Pair::from(3, 3), Pair::from(4, 1)];
        $bigger = function (Pair $value, Pair $initial): int {
            return $value->second() <=>  $initial->second();
        };

        self::assertEquals(1, worst($collection, $bigger)->second());
    }

    public function testWorstReturnsFirstWorst(): void
    {
        $collection = [Pair::from('A', 1), Pair::from('B', 2), Pair::from('C', 3), Pair::from('D', 1)];
        $bigger = function (Pair $value, Pair $initial): int {
            return $value->second() <=>  $initial->second();
        };

        self::assertEquals('A', worst($collection, $bigger)->first());
    }
}
