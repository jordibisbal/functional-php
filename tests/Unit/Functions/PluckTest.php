<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\pluck;

/** @covers ::\j45l\functional\pluck() */
class PluckTest extends TestCase
{
    /**
     * @return array<array<mixed>>
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public static function pluckDataProvider(): array
    {
        return [
            'No elements' => [[], [], 'none'],
            'With missing properties' => [
                ['emailValue', 'default'],
                [['email' => 'emailValue'], []],
                'email',
            ],
            'Nested' => [
                [123 => 'emailValue', 456 => 'secondEmail'],
                [123 => ['user' => ['email' => 'emailValue']], 456 => ['user' => ['email' => 'secondEmail']]],
                ['user', 'email'],
            ],
        ];
    }

    /**
     * @param mixed[] $expected
     * @param mixed[] $collection
     * @param mixed   $properties
     * @dataProvider pluckDataProvider
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function testPluck(array $expected, array $collection, mixed $properties): void
    {
        self::assertEquals($expected, pluck($collection, $properties, 'default'));
    }
}
