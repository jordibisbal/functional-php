<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use Closure;
use PHPUnit\Framework\Attributes\CoversFunction;
use RuntimeException;
use PHPUnit\Framework\TestCase;

use function j45l\functional\tailRecursion;

#[CoversFunction('j45l\functional\tailRecursion')]
class TailRecursionTest extends TestCase
{
    public function testItCanRecurseAThousandTimes(): void
    {
        $tailRecursion = static function ($x) use (&$tailRecursion) {
            /** @phpstan-var Closure $tailRecursion */
            return match (true) {
                $x === 1000 => $x,
                default => $tailRecursion($x + 1),
            };
        };

        $tailRecursion = tailRecursion($tailRecursion);

        self::assertEquals(1000, $tailRecursion(1));
    }

    public function testItCanRecurseAThousandTimesForMethod(): void
    {
        $tailRecursion = tailRecursion($this->depthRecursive(1000, $tailRecursion));

        self::assertEquals(1000, $tailRecursion(1));
    }

    public function testItCanRecurseBelowLimitTimesForMethod(): void
    {
        $tailRecursion = $this->depthRecursive(50, $tailRecursion);

        self::assertEquals(50, $tailRecursion(1));
    }

    public function testItCannotRecurseAboveLimitTimesForMethod(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Too depth.');

        $tailRecursion = $this->depthRecursive(1000, $tailRecursion);
        $tailRecursion(1);
    }

    /** @param Closure $recurse */
    private function depthRecursive(int $times, mixed &$recurse): Closure
    {
        return static function ($x) use ($times, &$recurse) {
            if (count(debug_backtrace()) > 100) {
                throw new RuntimeException('Too depth.');
            }
            return match (true) {
                $x === $times => $x,
                default => $recurse($x + 1),
            };
        };
    }
}
