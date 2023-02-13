<?php

namespace j45l\functional\Test\Unit\Functions;

use Closure;
use j45l\functional\Tuples\Pair;
use PHPUnit\Framework\TestCase;
use function Functional\map;
use function j45l\functional\cartesianProduct;
use function j45l\functional\yieldIterable;
use function PHPUnit\Framework\assertEquals;

class CartesianProductTest extends TestCase
{
    /**
     * @return       array<mixed>
     */
    public function quotientProductProvider(): array
    {
        return [
            'no vectors' => [[], []],
            '1 Vector'   => [[1, 2, 3, 4], [[1, 2, 3, 4]]],
            '2 Vectors'  => [[
                    '1 x a', '1 x b', '1 x c',
                    '2 x a', '2 x b', '2 x c',
                    '3 x a', '3 x b', '3 x c',
                    '4 x a', '4 x b', '4 x c'
                ],
                [[1, 2, 3, 4],['a', 'b', 'c']]
            ],
            '3 Vectors'  => [[
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
     * @dataProvider quotientProductProvider
     */
    public function testCartesianProductOfVectors(?array $result, array $vectors): void
    {
        $this->assertEquals($result, cartesianProduct($vectors, $this->stringProduct(...)));
    }

    /**
     * @param        array<mixed>|Null   $result
     * @param        array<array<mixed>> $vectors
     * @dataProvider quotientProductProvider
     */
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
}
