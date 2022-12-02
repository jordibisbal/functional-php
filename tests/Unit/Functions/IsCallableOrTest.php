<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\falseFn;
use function j45l\functional\identity;
use function j45l\functional\isCallableOr;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

class IsCallableOrTest extends TestCase
{
    public function testIsCallableIs(): void
    {
        assertEquals(
            identity(...),
            isCallableOr(identity(...), falseFn(...))
        );
    }

    public function testIsCallableIsNot(): void
    {
        assertEquals(
            falseFn(...),
            isCallableOr(42, falseFn(...))
        );
    }

    public function testIsCallableIsNotDefaultsNull(): void
    {
        assertNull(isCallableOr(42));
    }
}
