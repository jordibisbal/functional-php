<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\merge;

class MergeTest extends TestCase
{
    /**
     * @phpstan-return mixed[][][]
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function mergeDataProvider(): array
    {
        return [
            'arrays' => [[1, 2, 'A', 'B'], [[1, 2], ['A', 'B']]],
            'override with right' => [
                ['A' => 'a', 'B' => 'br', 0 => 'C', 1 => 'cr'],
                [['A' => 'a', 'B' => 'b', 2 => 'C'], ['B' => 'br', 3 => 'cr']]
            ],
            'merge not recursive' => [
                ['A' => ['br']], [['A' => ['b', 'c']], ['A' => ['br']]]
            ]
        ];
    }

    /**
     * @param mixed[] $expected
     * @param mixed[] $collections
     * @dataProvider mergeDataProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testMerge(array $expected, array $collections): void
    {
        self::assertEquals($expected, merge(...$collections));
    }
}
