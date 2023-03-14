<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use Generator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;

use function j45l\functional\PHPUnit\assertYields;
use function j45l\functional\yieldIterable;

/** @covers ::\j45l\functional\PHPUnit\assertYields */
class AssertYieldsTest extends TestCase
{
    /** @return array<string, array<mixed, mixed>> */
    public static function assertYieldsProvider(): array
    {
        return [
            'Empty' => [yieldIterable([]), yieldIterable([])],
            'Single' => [yieldIterable(['a']), yieldIterable(['a'])],
            'Simple' => [yieldIterable(['a', 'b', 'c']), yieldIterable(['a', 'b', 'c'])],
        ];
    }

    #[DataProvider('assertYieldsProvider')]
    public function testAssertYields(Generator $expected, Generator $actual): void
    {
        assertYields($expected, $actual);
    }

    /** @return array<string, array<mixed, mixed>> */
    public static function assertYieldsWithIndicesProvider(): array
    {
        return [
            'Empty' => [yieldIterable([]), yieldIterable([])],
            'Single' => [yieldIterable(['a'], ['A']), yieldIterable(['a'], ['A'])],
            'Simple' => [
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C']),
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C'])
            ],
            'doubled' => [
                yieldIterable(['a', 'b', 'b', 'c'], ['A', 'B', 'B', 'C']),
                yieldIterable(['a', 'b', 'b', 'c'], ['A', 'B', 'B', 'C'])
            ],
            'doubled indices' => [
                yieldIterable(['a', 'b', 'b', 'c'], ['A', 'B', 'B\'', 'C']),
                yieldIterable(['a', 'b', 'b', 'c'], ['A', 'B', 'B\'', 'C'])
            ],
            'doubled values' => [
                yieldIterable(['a', 'b', 'b\'', 'c'], ['A', 'B', 'B', 'C']),
                yieldIterable(['a', 'b', 'b\'', 'c'], ['A', 'B', 'B', 'C'])
            ],
        ];
    }

    #[DataProvider('assertYieldsWithIndicesProvider')]
    public function testAssertYieldsWithIndices(Generator $expected, Generator $actual): void
    {
        assertYields($expected, $actual);
    }

    /** @return array<string, array<mixed, mixed>> */
    public static function assertYieldsFailuresProvider(): array
    {
        return [
            'Empty' => [yieldIterable(['x']), yieldIterable([])],
            'Single not empty' => [yieldIterable([]), yieldIterable(['a'])],
            'Simple skipping key' => [
                yieldIterable(['a', 'c'], ['A', 'C']),
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C'])
            ],
            'Simple skipping value' => [
                yieldIterable(['a', 'c'], ['A', 'C']),
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C'])
            ],
            'Simple wrong value' => [
                yieldIterable(['a', 'b', 'c'], ['A', 'X', 'C']),
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C'])
            ],
            'Skipping doubled' => [
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C']),
                yieldIterable(['a', 'b', 'b', 'c'], ['A', 'B', 'B', 'C'])
            ],
            'Skipping doubled indices' => [
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C']),
                yieldIterable(['a', 'b', 'b', 'c'], ['A', 'B', 'B\'', 'C'])
            ],
            'Skipping doubled values' => [
                yieldIterable(['a', 'b', 'c'], ['A', 'B', 'C']),
                yieldIterable(['a', 'b', 'b\'', 'c'], ['A', 'B', 'B', 'C'])
            ],
        ];
    }

    #[DataProvider('assertYieldsFailuresProvider')]
    public function testAssertYieldsFailures(Generator $expected, Generator $actual): void
    {
        $this->expectException(ExpectationFailedException::class);

        assertYields($expected, $actual);
    }
}
