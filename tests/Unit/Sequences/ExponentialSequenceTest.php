<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Sequences;

use j45l\functional\Sequences\ExponentialSequence;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

final class ExponentialSequenceTest extends TestCase
{
    public function testReturnsExpectedDefaultSequence(): void
    {
        $returned = [];
        $sequence = ExponentialSequence::create(2, 1);

        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();

        assertEquals([1, 2, 4, 8], $returned);
    }

    public function testReturnsExpectedScaledSequence(): void
    {
        $returned = [];
        $sequence = ExponentialSequence::create(3, 2);

        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();

        assertEquals([2, 6, 18, 54], $returned);
    }

    public function testReturnsExpectedBaseSequence(): void
    {
        $returned = [];
        $sequence = ExponentialSequence::create(3);

        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();
        $sequence = $sequence->next();
        $returned[] = $sequence->value();

        assertEquals([1, 3, 9, 27], $returned);
    }

    public function testSequenceDoesNotChange(): void
    {
        $sequence = ExponentialSequence::create(2);

        $changedSequence = $sequence->next();

        assertEquals(1, $sequence->value());
        assertEquals(2, $changedSequence->value());
    }
}
