<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\falseFn;
use function PHPUnit\Framework\assertFalse;

#[CoversFunction('j45l\functional\falseFn')]
class FalseFnTest extends TestCase
{
    public function testFalse(): void
    {
        assertFalse(falseFn());
    }
}
