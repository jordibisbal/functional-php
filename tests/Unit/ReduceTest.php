<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\reduce;

class ReduceTest extends TestCase
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function testReducesLeft(): void
    {
        $concat = static function ($value, $index, $collection, $initial): string {
            return $initial . $value;
        };

        self::assertEquals('ABC', reduce(['A', 'B', 'C'], $concat));
    }
}
