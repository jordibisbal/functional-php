<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\butLast;

class ButLastTest extends TestCase
{
    public function testEmptyArray(): void
    {
        self::assertEquals([], butLast([]));
    }

    public function testSingleElementArray(): void
    {
        self::assertEquals([], butLast([1]));
    }

    public function testTwoElementArray(): void
    {
        self::assertEquals([1], butLast([1, 2]));
    }

    public function testMultipleElementArray(): void
    {
        self::assertEquals([1, 2], butLast([1, 2, 3]));
    }
}
