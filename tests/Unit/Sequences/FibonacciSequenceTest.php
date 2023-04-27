<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Sequences;

use j45l\functional\Sequences\FibonacciSequence;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

final class FibonacciSequenceTest extends TestCase
{
    public function testReturnsExpectedSequence(): void
    {
        $returned = [];
        $sequence = FibonacciSequence::create();

        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();

        assertEquals([1, 1, 2, 3, 5], $returned);
    }

    public function testReturnsExpectedSequenceStartingAtZero(): void
    {
        $returned = [];
        $sequence = FibonacciSequence::create(0);

        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();

        assertEquals([0, 1, 1, 2, 3], $returned);
    }

    public function testReturnsExpectedSequenceStartingAhead(): void
    {
        $returned = [];
        $sequence = FibonacciSequence::create(13);

        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();

        assertEquals([13, 21, 34, 55, 89], $returned);
    }
    public function testReturnsExpectedSequenceStartingAtNotFibonacci(): void
    {
        $returned = [];
        $sequence = FibonacciSequence::create(6);

        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();
        $sequence = $sequence->next();
        $returned[] = $sequence->current();

        assertEquals([6, 8, 14, 22, 36], $returned);
    }

    public function testReturnsExpectedIterationSequence(): void
    {
        $returned = [];
        $sequence = FibonacciSequence::create();


        $returned[] = $sequence->iteration();
        $sequence = $sequence->next();
        $returned[] = $sequence->iteration();
        $sequence = $sequence->next();
        $returned[] = $sequence->iteration();
        $sequence = $sequence->next();
        $returned[] = $sequence->iteration();

        assertEquals([1, 2, 3, 4], $returned);
    }

    public function testSequenceDoesNotChange(): void
    {
        $sequence = FibonacciSequence::create(2);

        $changedSequence = $sequence->next();

        assertEquals(2, $sequence->current());
        assertEquals(3, $changedSequence->current());
    }
}
