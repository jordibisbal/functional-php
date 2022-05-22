<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use LogicException;
use PHPUnit\Framework\TestCase;

use function j45l\functional\apply;

final class ApplyTest extends TestCase
{
    public function testAppliedFunctionDoesNotGetExecuted(): void
    {
        $callable = function () {
            throw new LogicException('Should not be called');
        };

        self::assertIsCallable(apply($callable, 42));
    }

    public function testAppliedParametersAreApplied(): void
    {
        $callable = function ($a, $b) {
            return $a - $b;
        };

        self::assertEquals(42, apply($callable, 43, 1)());
    }

    public function testAppliedParametersAreAddedFromCallbackAndApplied(): void
    {
        $callable = function ($a, $b) {
            return $a - $b;
        };

        self::assertEquals(42, apply($callable, 1)(43));
    }
}
