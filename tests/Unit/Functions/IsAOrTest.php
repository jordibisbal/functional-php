<?php

namespace j45l\functional\Test\Unit\Functions;

use j45l\functional\Test\Unit\Fixtures\ValueObjectA;
use j45l\functional\Test\Unit\Fixtures\ValueObjectB;
use PHPUnit\Framework\TestCase;

use function j45l\functional\isAOr;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNull;

class IsAOrTest extends TestCase
{
    public function testIsAIs(): void
    {
        assertEquals(
            new ValueObjectA('1'),
            isAOr(new ValueObjectA('1'), ValueObjectA::class, 'whatever')
        );
    }

    public function testIsAIsNotTHenWrapping(): void
    {
        assertEquals(
            new ValueObjectA('1'),
            isAOr('1', ValueObjectA::class, fn ($x): ValueObjectA => new ValueObjectA($x))
        );
    }

    public function testIsAIsNot(): void
    {
        assertEquals(
            new ValueObjectA('42'),
            isAOr(new ValueObjectB('1'), ValueObjectA::class, new ValueObjectA('42'))
        );
    }

    public function testIsAIsNotObject(): void
    {
        assertEquals(
            new ValueObjectA('42'),
            isAOr(1, ValueObjectA::class, new ValueObjectA('42'))
        );
    }

    public function testIsAIsNotObjectDefaultNull(): void
    {
        assertNull(
            isAOr(1, ValueObjectA::class)
        );
    }
}
