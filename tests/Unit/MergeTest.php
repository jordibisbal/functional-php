<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\merge;
use function j45l\functional\toArray;
use function j45l\functional\yieldIterable;

class MergeTest extends TestCase
{
    /**
     * @phpstan-return mixed[][][]
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function relayDataProvider(): array
    {
        return [
            'arrays' => [[1, 2, 'A', 'B'], [[1, 2], ['A', 'B']]],
            'generators' => [[1, 2, 'A', 'B'], [yieldIterable([1, 2]), yieldIterable(['A', 'B'])]],
            'mixed' => [[1, 2, 'A', 'B'], [[1, 2], yieldIterable(['A', 'B'])]],
        ];
    }

    /**
     * @param mixed[] $expected
     * @param mixed[] $collections
     * @dataProvider relayDataProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testRelay(array $expected, array $collections): void
    {
        self::assertEquals($expected, toArray(merge(...$collections)));
    }
}
