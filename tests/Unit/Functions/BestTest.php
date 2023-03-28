<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Tuples\Pair;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\best;

#[CoversFunction('j45l\functional\best')]
class BestTest extends TestCase
{
    public function testBestOnEmptyReturnsNullWhenNoDefault(): void
    {
        self::assertNull(best([], $this->biggerThan(...)));
    }

    public function testBestOnEmptyReturnsDefault(): void
    {

        self::assertEquals(42, best([], $this->biggerThan(...), 42));
    }

    public function testBestReturnsBest(): void
    {
        self::assertEquals(
            2,
            best(
                [Pair::from('A', 1), Pair::from('B', 2), Pair::from('C', 2), Pair::from('D', 1)],
                $this->biggerSecondThan(...)
            )->second()
        );
    }

    public function testBestReturnsFirstBest(): void
    {
        self::assertEquals(
            'B',
            best(
                [Pair::from('A', 1), Pair::from('B', 2), Pair::from('C', 2), Pair::from('D', 1)],
                $this->biggerSecondThan(...)
            )->first()
        );
    }

    public function biggerThan(int $first, int $second): bool
    {
        return $first > $second;
    }

    /**
     * @param Pair<string, int> $value
     * @param Pair<string, int> $initial
     */
    public function biggerSecondThan(Pair $value, Pair $initial): bool
    {
        return $value->second() >  $initial->second();
    }
}
