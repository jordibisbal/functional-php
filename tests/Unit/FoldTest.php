<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\fold;

class FoldTest extends TestCase
{
    public function testFold(): void
    {
        $concat = static function ($value, $collection, $initial): string {
            return $initial . $value;
        };

        self::assertEquals('ABC', fold(['A', 'B', 'C'], $concat));
    }
}
