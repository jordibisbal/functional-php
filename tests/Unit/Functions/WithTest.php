<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use LogicException;
use PHPUnit\Framework\TestCase;

use function j45l\functional\with;

final class WithTest extends TestCase
{
    public function testAppliedFunctionDoesNotGetExecuted(): void
    {
        $callable = function () {
            throw new LogicException('Should not be called');
        };

        self::assertIsCallable(with($callable, 42));
    }

    public function testAppliedParametersAreApplied(): void
    {
        $callable = function ($a, $b) {
            return $a - $b;
        };

        self::assertEquals(42, with($callable, 43, 1)());
    }
}
