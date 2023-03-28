<?php

namespace j45l\functional\Test\Unit\Functions;

use Closure;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\recurseTimes;

#[CoversFunction('j45l\functional\recurseTimes')]
class RecurseTimesTest extends TestCase
{
    public function testRepeatWithZeroReturnInitialValue(): void
    {
        self::assertEquals(123, recurseTimes($this->increment())(0)(123));
    }

    public function testRepeatReturnInitialValueMapped(): void
    {
        self::assertEquals(124, recurseTimes($this->increment())(1)(123));
    }

    public function testRepeatTenTimeReturnInitialValueMappedTenTimes(): void
    {
        self::assertEquals(133, recurseTimes($this->increment())(10)(123));
    }

    /**
     * @return Closure(int) : int
     */
    private function increment(): Closure
    {
        return static function (int $value): int {
            return $value + 1;
        };
    }
}
