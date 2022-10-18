<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\reduce;

class ReduceTest extends TestCase
{
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testReduces(): void
    {
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $value;
        };

        self::assertEquals(':ABC', reduce(['A', 'B', 'C'], $concat, ':'));
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testReducesIndexed(): void
    {
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $index;
        };

        self::assertEquals(':⍺βγ', reduce(['⍺' => 'A', 'β' => 'B', 'γ' => 'C'], $concat, ':'));
    }
}
