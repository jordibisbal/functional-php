<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertTrue;

class TrueFnTest extends TestCase
{
    public function testFalse(): void
    {
        assertTrue(trueFn());
    }
}
