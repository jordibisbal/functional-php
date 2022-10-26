<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\with;

final class WithTest extends TestCase
{
    public function testAppliedParametersAreApplied(): void
    {
        self::assertEquals(42, with(43, 1)(static fn($x, $y) => $x - $y));
    }
}
