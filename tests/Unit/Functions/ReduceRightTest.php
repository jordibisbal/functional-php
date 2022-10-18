<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\reduceRight;

class ReduceRightTest extends TestCase
{
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testReducesRight(): void
    {
/** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $value;
        };

        self::assertEquals(':CBA', reduceRight(['A', 'B', 'C'], $concat, ':'));
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testReducesIndexed(): void
    {
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $index;
        };

        self::assertEquals(':γβ⍺', reduceRight(['⍺' => 'A', 'β' => 'B', 'γ' => 'C'], $concat, ':'));
    }
}
