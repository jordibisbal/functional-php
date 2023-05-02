<?php

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Tuples\Pair;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function j45l\functional\cartesianProduct;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\cartesianProduct')]
class CartesianProductTest extends TestCase
{
    /**
     * @return       array<mixed>
     */
    public static function quotientProductArrayProvider(): array
    {
        return [
            'no array' => [[], []],
            '1 array'   => [[1, 2, 3, 4], [[1, 2, 3, 4]]],
            '2 arrays'  => [
                [
                    [1, 'a'], [1, 'b'], [1, 'c'],
                    [2, 'a'], [2, 'b'], [2, 'c'],
                    [3, 'a'], [3, 'b'], [3, 'c'],
                    [4, 'a'], [4, 'b'], [4, 'c']
                ],
                [[1, 2, 3, 4], ['a', 'b', 'c']]
            ],
            '3 Arrays'  => [
                [
                    [1, ['a', '⍺']], [1, ['a', 'β']], [1, ['b', '⍺']], [1, ['b', 'β']], [1, ['c', '⍺']], [1, ['c', 'β']],
                    [2, ['a', '⍺']], [2, ['a', 'β']], [2, ['b', '⍺']], [2, ['b', 'β']], [2, ['c', '⍺']], [2, ['c', 'β']],
                    [3, ['a', '⍺']], [3, ['a', 'β']], [3, ['b', '⍺']], [3, ['b', 'β']], [3, ['c', '⍺']], [3, ['c', 'β']],
                    [4, ['a', '⍺']], [4, ['a', 'β']], [4, ['b', '⍺']], [4, ['b', 'β']], [4, ['c', '⍺']], [4, ['c', 'β']],
                ],
                [[1, 2, 3, 4], ['a', 'b', 'c'], ['⍺', 'β']]
            ]
        ];
    }

    /**
     * @param        array<mixed>|Null   $result
     * @param        array<array<mixed>> $vectors
     */
    #[DataProvider('quotientProductArrayProvider')]
    public function testCartesianProductOfVectorsAsArray(?array $result, array $vectors): void
    {
        $this->assertEquals($result, cartesianProduct($vectors, $this->arrayProduct(...)));
    }

    /**
     * @return       array<mixed>
     */
    public static function quotientProductProvider(): array
    {
        return [
            'no vectors' => [[], []],
            '1 Vector'   => [[1, 2, 3, 4], [[1, 2, 3, 4]]],
            '2 Vectors'  => [
                [
                    '1 x a', '1 x b', '1 x c',
                    '2 x a', '2 x b', '2 x c',
                    '3 x a', '3 x b', '3 x c',
                    '4 x a', '4 x b', '4 x c'
                ],
                [[1, 2, 3, 4], ['a', 'b', 'c']]
            ],
            '3 Vectors'  => [
                [
                    '1 x a x ⍺', '1 x a x β', '1 x b x ⍺', '1 x b x β', '1 x c x ⍺', '1 x c x β',
                    '2 x a x ⍺', '2 x a x β', '2 x b x ⍺', '2 x b x β', '2 x c x ⍺', '2 x c x β',
                    '3 x a x ⍺', '3 x a x β', '3 x b x ⍺', '3 x b x β', '3 x c x ⍺', '3 x c x β',
                    '4 x a x ⍺', '4 x a x β', '4 x b x ⍺', '4 x b x β', '4 x c x ⍺', '4 x c x β',
                ],
                [[1, 2, 3, 4], ['a', 'b', 'c'], ['⍺', 'β']]
            ]
        ];
    }

    /**
     * @param        array<mixed>|Null   $result
     * @param        array<array<mixed>> $vectors
     */
    #[DataProvider('quotientProductProvider')]
    public function testCartesianProductOfVectors(?array $result, array $vectors): void
    {
        $this->assertEquals($result, cartesianProduct($vectors, $this->stringProduct(...)));
    }

    /**
     * @param        array<mixed>|Null   $result
     * @param        array<array<mixed>> $vectors
     */
    #[DataProvider('quotientProductProvider')]
    public function testCartesianProductOfGenerators(?array $result, array $vectors): void
    {
        $this->assertEquals(
            $result,
            cartesianProduct($vectors, $this->stringProduct(...))
        );
    }

    public function testCartesianProductReturnsPairsIfNoProductFunctionIsProvided(): void
    {
        assertEquals(
            [Pair::from(1, 'a'), Pair::from(1, 'b')],
            cartesianProduct([[1],['a','b']])
        );
    }

    private function stringProduct(string $one, string $another): string
    {
        return sprintf('%s x %s', $one, $another);
    }

    /** @return mixed[] */
    private function arrayProduct(mixed ...$elements): array
    {
        return $elements;
    }
}
