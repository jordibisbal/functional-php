<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Tuples\Pair;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\worst;

#[CoversFunction('j45l\functional\worst')]
class WorstTest extends TestCase
{
    public function testWorstOnEmptyReturnsNullWhenNoDefault(): void
    {
        self::assertNull(worst([], fn($first, $second): bool => $first > $second));
    }

    public function testWorstOnEmptyReturnsDefault(): void
    {
        self::assertEquals(42, worst([], fn($first, $second): bool => $first > $second, 42));
    }

    public function testWorstReturnsWorst(): void
    {
        self::assertEquals(
            1,
            worst(
                [Pair::from(1, 1), Pair::from(2, 2), Pair::from(3, 3), Pair::from(4, 1)],
                fn(Pair $value, Pair $initial): bool => $value->second() >  $initial->second()
            )->second()
        );
    }

    public function testWorstReturnsFirstWorst(): void
    {
        self::assertEquals(
            'A',
            worst(
                [Pair::from('A', 1), Pair::from('B', 2), Pair::from('C', 3), Pair::from('D', 1)],
                fn (Pair $value, Pair $initial): bool => $value->second() >=  $initial->second()
            )->first()
        );
    }
}
