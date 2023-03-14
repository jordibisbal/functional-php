<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\falseFn;
use function j45l\functional\identity;
use function j45l\functional\isClosureOr;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

/** @covers ::\j45l\functional\isClosureOr */
class IsClosureOrTest extends TestCase
{
    public function testIsCallableIs(): void
    {
        assertEquals(
            identity(...),
            isClosureOr(identity(...), falseFn(...))
        );
    }

    public function testIsCallableIsNot(): void
    {
        assertEquals(
            falseFn(...),
            isClosureOr(42, falseFn(...))
        );
    }

    public function testIsCallableIsNotDefaultsNop(): void
    {
        assertNull(isClosureOr(42)());
    }
}
