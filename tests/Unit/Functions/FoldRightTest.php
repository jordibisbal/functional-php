<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\foldRight;

class FoldRightTest extends TestCase
{
    public function testFold(): void
    {
        self::assertEquals(
            'CBA',
            foldRight(['A', 'B', 'C'], static fn($value, $initial): string => $initial . $value)
        );
    }
}
