<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\identity;
use function PHPUnit\Framework\assertSame;

/** @covers ::\j45l\functional\identity() */
class IdentityTest extends TestCase
{
    /**
     * @return array<mixed>
     */
    public function valuesProvider(): array
    {
        return [
            'int' => [1],
            'null' => [null],
            'float' => [1.0],
            'string' => ['1'],
            'array' => [[1, 2]],
            'object' => [(object) [1]],
        ];
    }

    /** @dataProvider valuesProvider */
    public function testFalse(mixed $x): void
    {
        assertSame($x, identity($x));
    }
}
