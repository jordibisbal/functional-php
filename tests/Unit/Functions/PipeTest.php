<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\pipe;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

class PipeTest extends TestCase
{
    public function testEmptyPipeReturnsNull(): void
    {
        assertNull(pipe());
    }

    public function testSingleComposeEvaluation(): void
    {
        assertEquals(42, pipe(fn () => 42));
    }

    public function testComposeEvaluatesFromLeftToRight(): void
    {
        assertEquals(
            42,
            pipe(
                fn () => 41,
                fn ($x) => $x + 1,
            )
        );
    }
}
