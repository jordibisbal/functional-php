<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\identity;
use function j45l\functional\traverse;
use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertEquals;

/** @covers ::\j45l\functional\traverse() */
class TraverseTest extends TestCase
{
    public function testTraverseSingleValue(): void
    {
        $target = [
            'foo' => 'bar',
            'bacon' => 'spam'
        ];

        self::assertEquals(
            ['bacon' => 'spam'],
            traverse(
                $target,
                [
                    [fn ($value): bool => $value === 'spam']
                ]
            )
        );
    }

    public function testTraverseSingleValueAndKey(): void
    {
        $target = [
            'foo' => 'bar',
            'bacon' => 'spam',
            'eggs' => 'spam'
        ];

        self::assertEquals(
            ['bacon' => 'spam'],
            traverse(
                $target,
                [
                    [fn ($value, $key) => [$key, $value] === ['bacon', 'spam']]
                ]
            )
        );
    }

    public function testTraverseMultipleValue(): void
    {
        $target = [
            'foo' => 'bar',
            'bacon' => 'spam',
            'eggs' => 'spam'
        ];

        self::assertEquals(
            [
                'bacon' => 'spam',
                'eggs' => 'spam'
            ],
            traverse(
                $target,
                [
                    [fn ($value) => $value === 'spam']
                ]
            )
        );
    }

    public function testTraversingOnce(): void
    {
        $target = [
            [
                'bacon' => 'spam',
                'eggs' => ['sausage' => 'spam']
            ],
            [
                'bacon' => 'spam',
                'eggs' => ['bacon' => 'spam']
            ],
            [
                'spam' => 'spam',
                'eggs' => 'spam'
            ]
        ];

        self::assertEquals(
            [
                'bacon' => 'spam'
            ],
            traverse(
                $target,
                [
                    [fn ($value, $key) => ($value['bacon'] ?? null) === 'spam', fn ($value) => $value['eggs'] ?? null],
                    [fn ($value, $key) => $key === 'bacon', identity(...)],
                ]
            )
        );
    }

    public function testTraversingTwice(): void
    {
        $target = [
            [
                'bacon' => 'spam',
                'eggs' => ['sausage' => 'spam']
            ],
            [
                'bacon' => 'spam',
                'eggs' => ['sausage' => ['tomato' => 'spam']]
            ],
            [
                'bacon' => 'spam',
                'eggs' => ['bacon' => 'spam']
            ],
            [
                'bacon' => 'spam',
                'eggs' => ['sausage' => ['lobster' => 'spam']]
            ],
            [
                'spam' => 'spam',
                'eggs' => 'spam'
            ]
        ];

        self::assertEquals(
            [
                'lobster' => 'spam'
            ],
            traverse(
                $target,
                [
                    [fn ($value, $key) => ($value['bacon'] ?? null) === 'spam', fn ($value) => $value['eggs'] ?? null],
                    [fn ($value, $key) => $key === 'sausage'],
                    [fn ($value, $key) => $key === 'lobster'],
                ]
            )
        );
    }

    public function testExampleData(): void
    {
        $whiskeys = [
            'Single Malt' => [
                'Glenmorangie' => [
                    'region' => 'Highland, Scotland',
                    'whiskeys' => [
                        [ 'name' => 'Signet', 'price' => '236.00' ],
                    ],
                ],
                'Macallan' => [
                    'region' => 'Highland, Scotland',
                    'whiskeys' => [
                        [ 'name' => '12 Year Double Cask', 'price' => '79.00' ],
                    ],
                ],
                'Yamazaki' => [
                    'region' => 'Japan',
                    'whiskeys' => [
                        [ 'name' => '12 Year Old', 'price' => '180.00' ],
                    ],
                ],
            ],
            'Blended' => [
                'Buchanan' => [
                    'region' => 'Scotland',
                    'whiskeys' => [
                        [ 'name' => '12 Year Scotch', 'price' => '32.00' ]
                    ],
                ]
            ]
        ];

        assertEquals(
            [
                [ 'distillery' => 'Macallan', 'name' => '12 Year Double Cask', 'price' => '79.00', ],
                [ 'distillery' => 'Yamazaki', 'name' => '12 Year Old', 'price' => '180.00',]
            ],
            traverse(
                $whiskeys,
                [
                    [ fn($_, $type) => $type === 'Single Malt' ],
                    [ trueFn(...), fn($distillery) => $distillery['whiskeys'] ],
                    [
                        fn ($value) => (float) $value['price'] < 200,
                        fn ($node, $path) =>
                            ['distillery' => $path[1], 'name' => $node['name'], 'price' => $node['price']]
                    ],
                ]
            )
        );
    }
}
