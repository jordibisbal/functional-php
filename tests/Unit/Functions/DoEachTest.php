<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\doEach;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\doEach')]
class DoEachTest extends TestCase
{
    public function testEachExecutesForEveryElement(): void
    {
        $collectedItems = [];
        $collector = function ($value, $key) use (&$collectedItems) {
            $collectedItems[$value] = $key;
        };

        doEach([1 => 'a',2 => 'b', 3 => 'c'], $collector);

        assertEquals(
            ['a' => 1, 'b' => 2, 'c' => 3],
            $collectedItems
        );
    }
    public function testEachExecutesForEveryElementWithEmptyCollection(): void
    {
        $collectedItems = [];
        $collector = function ($value, $key) use (&$collectedItems) {
            $collectedItems[$value] = $key;
        };

        doEach([], $collector);

        assertEquals(
            [],
            $collectedItems,
        );
    }
}
