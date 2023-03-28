<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\head;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

#[CoversFunction('j45l\functional\head')]
class HeadTest extends TestCase
{
    public function testFirstReturnsFirst(): void
    {
        assertEquals(1, head([1, 2, 3]));
    }


    public function testFirstReturnsNullIfNoElements(): void
    {
        assertNull(head([]));
    }

    public function testFirstReturnsDefaultIfNoElementsAndDefaultStated(): void
    {
        assertEquals('default', 'default');
    }
}
