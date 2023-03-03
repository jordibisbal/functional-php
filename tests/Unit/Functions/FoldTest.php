<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\fold;

/** @covers ::\j45l\functional\fold() */
class FoldTest extends TestCase
{
    public function testFold(): void
    {
        self::assertEquals(
            'ABC',
            fold(['A', 'B', 'C'], static fn($initial, $value): string => $initial . $value)
        );
    }
}
