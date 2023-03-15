<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Sequences;

use j45l\functional\Sequences\ExponentialSequence;
use j45l\functional\Sequences\SequenceIterator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(SequenceIterator::class)]
final class SequenceIteratorTest extends TestCase
{
    public function testReturnsExpectedSequence(): void
    {
        $iterator = SequenceIterator::create(ExponentialSequence::create(2));

        assertEquals(1, $iterator->current());
        assertEquals(0, $iterator->key());
        assertTrue($iterator->valid());

        $iterator->next();

        assertEquals(2, $iterator->current());
        assertEquals(1, $iterator->key());
        assertTrue($iterator->valid());

        $iterator->next();

        assertEquals(4, $iterator->current());
        assertEquals(2, $iterator->key());
        assertTrue($iterator->valid());

        $iterator->next();
    }

    public function testCanBeRewind(): void
    {
        $iterator = SequenceIterator::create(ExponentialSequence::create(2));

        assertEquals(1, $iterator->current());
        assertEquals(0, $iterator->key());

        $iterator->next();

        assertEquals(2, $iterator->current());
        assertEquals(1, $iterator->key());

        $iterator->next();

        $iterator->rewind();

        assertEquals(1, $iterator->current());
        assertEquals(0, $iterator->key());

        $iterator->next();

        assertEquals(2, $iterator->current());
        assertEquals(1, $iterator->key());
    }
}
