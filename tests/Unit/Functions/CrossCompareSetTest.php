<?php

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Tuples\Pair;
use PHPUnit\Framework\TestCase;
use function j45l\functional\crossCompareSet;
use function j45l\functional\yieldIterable;

class CrossCompareSetTest extends TestCase
{
    /**
     * @return       array<mixed>
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function quotientProductProvider(): array
    {
        return [
            'Vectors'  => [[
                Pair::from(1, 2), Pair::from(1, 3), Pair::from(1, 4),
                                  Pair::from(2, 3), Pair::from(2, 4),
                                                    Pair::from(3, 4)
            ],
                [1, 2, 3, 4]
            ]
        ];
    }

    /**
     * @param        array<mixed>|Null   $result
     * @param        array<array<mixed>> $vectors
     * @dataProvider quotientProductProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testCrossCompareSetFromArray(?array $result, array $vectors): void
    {
        $this->assertEquals($result, crossCompareSet($vectors));
    }

    /**
     * @param        array<mixed>|Null   $result
     * @param        array<array<mixed>> $vectors
     * @dataProvider quotientProductProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testCrossCompareSetFromGenerator(?array $result, array $vectors): void
    {
        $this->assertEquals($result, crossCompareSet(yieldIterable($vectors)));
    }
}
