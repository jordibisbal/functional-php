<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;
use function j45l\functional\pluck;

class PluckTest extends TestCase
{
    /**
     * @return array<array<mixed>>
     * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
     */
    public function pluckDataProvider(): array
    {
        return [
            'No elements' => [[], [], 'none'],
            'With missing properties' => [
                ['emailValue', 'default'],
                [['email' => 'emailValue'], []],
                'email',
            ],
            'Nested' => [
                ['emailValue', 'secondEmail'],
                [['user' => ['email' => 'emailValue']], ['user' => ['email' => 'secondEmail']]],
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
    public function testPluck(array $expected, array $collection, $properties): void
    {
        self::assertEquals($expected, pluck($collection, $properties, 'default'));
    }
}
