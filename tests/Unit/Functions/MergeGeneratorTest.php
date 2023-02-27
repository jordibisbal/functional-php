<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use Generator;
use PHPUnit\Framework\TestCase;

use function j45l\functional\also;
use function j45l\functional\mergeGenerator;
use function j45l\functional\PHPUnit\assertYields;
use function j45l\functional\yieldIterable;

class MergeGeneratorTest extends TestCase
{
    /**
     * @phpstan-return mixed[][][]
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function mergeGeneratorDataProvider(): array
    {
        return [
            'arrays' => [[0, 1, 0 , 1], [1, 2, 'A', 'B'], [[1, 2], ['A', 'B']]],
            'generators' => [[0, 1, 0 , 1], [1, 2, 'A', 'B'], [yieldIterable([1, 2]), yieldIterable(['A', 'B'])]],
            'mixed' => [[0, 1, 0 , 1], [1, 2, 'A', 'B'], [[1, 2], yieldIterable(['A', 'B'])]],
            'does not override with right' => [
                ['A', 'B', 0, 'B', 0],
                ['a', 'b', 'C', 'br', 'cr'],
                [yieldIterable(['A' => 'a', 'B' => 'b', 'C']), yieldIterable(['B' => 'br', 'cr'])]
            ],
            'merge not recursive' => [
                ['A', 'A'],
                [['B', 'C'], ['Br']],
                [yieldIterable(['A' => ['B', 'C']]), yieldIterable(['A' => ['Br']])]
            ]
        ];
    }

    /**
     * @param array<int|string>|null $expectedKeys
     * @param array<mixed> $expected
     * @param array<Generator> $generators
     * @dataProvider mergeGeneratorDataProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testMergeGenerator(?array $expectedKeys, array $expected, array $generators): void
    {
        match (true) {
            !is_null($expectedKeys) => also(
                fn () => assertYields(yieldIterable($expectedKeys, $expected), mergeGenerator(...$generators))
            )(null),
            default => also(
                fn () => assertYields(yieldIterable($expected), mergeGenerator(...$generators))
            )(null)
        };
    }
}
