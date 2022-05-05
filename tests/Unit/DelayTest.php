<?php

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\delay;

class DelayTest extends TestCase
{
    public function testFunctionCalledAfterDelay(): void
    {
        $sequence = [];
        $call = function () use (&$sequence) {
            $sequence[] = 'function called';
            return 'return value';
        };
        $delayFn = function ($seconds) use (&$sequence) {
            $sequence[] = 'delay ' . $seconds;
        };

        $return = delay(1.2, $call, $delayFn);

        self::assertEquals(['delay 1.2', 'function called'], $sequence);
        self::assertEquals('return value', $return);
    }

    public function testDefaultSystemDelay(): void
    {
        $sequence = [];
        $call = function () use (&$sequence) {
            $sequence[] = 'function called';
            return 'return value';
        };

        $time = microtime(true);
        $return = delay(0.100, $call);
        $time = microtime(true) - $time;

        self::assertEquals(['function called'], $sequence);
        self::assertEquals('return value', $return);
        self::assertEqualsWithDelta(0.100, $time, 0.010);
    }
}
