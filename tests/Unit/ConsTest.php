<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use PHPUnit\Framework\TestCase;

use function j45l\functional\cons;

class ConsTest extends TestCase
{
    public function testConsWrapsValue(): void
    {
        self::assertEquals(42, cons(42)());
    }
}
