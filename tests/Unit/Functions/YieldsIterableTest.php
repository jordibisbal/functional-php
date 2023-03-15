<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Sequences\ExponentialSequence;
use j45l\functional\Sequences\LinearSequence;
use j45l\functional\Sequences\Sequence;
use j45l\functional\Sequences\SequenceIterator;
use PHPUnit\Framework\TestCase;
use function j45l\functional\yieldIterable;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

/** @covers ::\j45l\functional\yieldIterable() */
class YieldsIterableTest extends TestCase
{
    public function testIterableArrayCanBeConsumed(): void
    {
        $actual = yieldIterable([1,2,3]);

        assertEquals(1, $actual->current());
        $actual->next();
        assertEquals(2, $actual->current());
        $actual->next();
        assertEquals(3, $actual->current());
        assertTrue($actual->valid());
        $actual->next();
        assertFalse($actual->valid());
    }

    public function testArrayKeysCanBeConsumed(): void
    {
        $actual = yieldIterable(['A', 'B', 'C'], ['a', 'b', 'c']);

        assertEquals('a', $actual->current());
        assertEquals('A', $actual->key());
        $actual->next();
        assertEquals('b', $actual->current());
        assertEquals('B', $actual->key());
        $actual->next();
        assertEquals('c', $actual->current());
        assertEquals('C', $actual->key());
    }

    public function testArrayKeysCanRepeatConsumed(): void
    {
        $actual = yieldIterable(['A', 'B', 'B'], ['a', 'b', 'c']);

        assertEquals('a', $actual->current());
        assertEquals('A', $actual->key());
        $actual->next();
        assertEquals('b', $actual->current());
        assertEquals('B', $actual->key());
        $actual->next();
        assertEquals('c', $actual->current());
        assertEquals('B', $actual->key());
    }

    public function testIterableCanBeConsumed(): void
    {
        $actual = yieldIterable(
            SequenceIterator::create(LinearSequence::create(1, 1)),
            SequenceIterator::create(ExponentialSequence::create(2, 1))
        );

        assertEquals(1, $actual->current());
        assertEquals(1, $actual->key());
        $actual->next();
        assertEquals(2, $actual->current());
        assertEquals(2, $actual->key());
        $actual->next();
        assertEquals(4, $actual->current());
        assertEquals(3, $actual->key());
    }
}
