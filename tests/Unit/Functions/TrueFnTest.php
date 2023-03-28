<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\trueFn;
use function PHPUnit\Framework\assertTrue;

#[CoversFunction('j45l\functional\trueFn')]
class TrueFnTest extends TestCase
{
    public function testFalse(): void
    {
        assertTrue(trueFn());
    }
}
