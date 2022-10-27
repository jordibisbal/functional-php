<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\id;
use function j45l\functional\traverse;

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
                    [fn ($value, $key) => $key === 'bacon', id(...)],
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
}
