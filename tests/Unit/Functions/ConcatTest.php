<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function j45l\functional\concat;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\concat')]
class ConcatTest extends TestCase
{
    /** @phpstan-return array<string, array{mixed[], string}> */
    public static function concatConcatsProvider(): array
    {
        return [
            'Empty' => [[], ''],
            'A string' => [['string'], 'string'],
            'Multiple strings' => [['A', 'B', 'C'], 'ABC'],
            'Multiple ints' => [[1, 2, 3], '123'],
            'Multiple floats' => [[1.1, 2.2, 3.3], '1.12.23.3'],
            'Multiple mixed' => [[1, 2.2, '3'], '12.23'],
        ];
    }

    /** @param array<mixed> $collection */
    #[DataProvider('concatConcatsProvider')]
    public function testEmptyConcatConcats(array $collection, string $expected): void
    {
        assertEquals($expected, concat($collection));
    }
}
