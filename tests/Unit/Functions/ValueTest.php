<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\value;

/** @covers ::\j45l\functional\value() */
class ValueTest extends TestCase
{
    public function testValueWrapsValue(): void
    {
        self::assertEquals(42, value(42)());
    }
}
