<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\reduce;
use function j45l\functional\reduceRight;

class ReduceRightTest extends TestCase
{
    public function testReducesRight(): void
    {
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $value;
        };

        self::assertEquals(':CBA', reduceRight(['A', 'B', 'C'], $concat, ':'));
    }

    public function testReducesIndexed(): void
    {
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $index;
        };

        self::assertEquals(':γβ⍺', reduceRight(['⍺' => 'A', 'β' => 'B', 'γ' => 'C'], $concat, ':'));
    }
}
