<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;
use function j45l\functional\foldRight;

class FoldRightTest extends TestCase
{
    public function testFold(): void
    {
        $concat = static function ($value, $initial): string {
            return $initial . $value;
        };

        self::assertEquals('CBA', foldRight(['A', 'B', 'C'], $concat));
    }
}
