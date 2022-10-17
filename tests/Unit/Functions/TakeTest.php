<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;
use function j45l\functional\take;

class TakeTest extends TestCase
{
    /**
     * @return array<array<mixed>>
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function takeDataProvider(): array
    {
        $target = [
            1 => 'one',
            2 => [ 3 => 4 ], 'two three',
            3 => (object) ['a' => 'b']
        ];

        return [
            'Neither array nor object' => ['potato', '1', 'default'],
            'No property' => [$target, [], 'default'],
            'Not found in array' => [$target, 'not found', 'default'],
            'Not found in object' => [(object) $target, 'not found', 'default'],
            'Index 1' => [$target, '1', 'one'],
            'Index 2, then 3' => [$target, [2, 3], 4],
            'Index 1 in object' => [(object) $target, '1', 'one'],
            'Index 2 in object, then 3' => [(object) $target, [2, 3], 4],
            'Index 3, then a' => [$target, [3, 'a'], 'b'],
            'Index 3 in object, then a' => [$target, [3, 'a'], 'b'],
        ];
    }

    /**
     * @phpstan-param array<mixed>|object $target
     * @param string|int|array<string|int> $propertyName
     * @param mixed $value
     * @dataProvider takeDataProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testTake($target, $propertyName, $value): void
    {
        self::assertEquals($value, take($target, $propertyName, 'default'));
    }

    public function testTakeCanGetPropertyByGetter(): void
    {
        $object = new class {
            public function property(): int
            {
                return 42;
            }
        };

        self::assertEquals(42, take($object, 'property', 'default'));
    }
}
