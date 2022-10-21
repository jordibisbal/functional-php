<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;
use function j45l\functional\false;
use function PHPUnit\Framework\assertFalse;

class FalseTest extends TestCase
{
    public function testFalse(): void
    {
        assertFalse(false());
    }
}
