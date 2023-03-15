<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Sequences;

use j45l\functional\Sequences\LinearSequence;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

final class LinearSequenceTest extends TestCase
{
    public function testReturnsExpectedSequence(): void
    {
        $returned = [];
        $sequence = LinearSequence::create(1, 2);

        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();

        assertEquals([1, 3, 5, 7], $returned);
    }

    public function testReturnsExpectedIterationSequence(): void
    {
        $returned = [];
        $sequence = LinearSequence::create(1, 2);


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
        $sequence = LinearSequence::create(1, 2);

        $changedSequence = $sequence->next();

        assertEquals(1, $sequence->value());
        assertEquals(3, $changedSequence->value());
    }
}
