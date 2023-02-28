<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;
use function j45l\functional\nop;
use function PHPUnit\Framework\assertNull;

class NopTest extends TestCase
{
    public function testReturnsNull(): void
    {
        assertNull(nop());
        assertNull(nop(...)());
    }
}
