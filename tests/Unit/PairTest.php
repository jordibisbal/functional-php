<?php

namespace j45l\functional\Test\Unit;

use j45l\functional\Pair;
use j45l\functional\Test\Unit\Fixtures\ValueObjectA;
use j45l\functional\Test\Unit\Fixtures\ValueObjectB;
use PHPUnit\Framework\TestCase;

/**
 * @covers \j45l\functional\Pair
 */
class PairTest extends TestCase
{
    public function testAPairCanBeCreateFromTwoPrimitives(): void
    {
        $pair = Pair::from(1, '1');

        $this->assertEquals(1, $pair->first());
        $this->assertEquals('1', $pair->second());
    }

    public function testAPairCanBeCreateFromTwoObjects(): void
    {
        // This test in fact helps to debug issues with template (generics) rendering within phpstorm
        // Try autocompletion and type validation on $pair->first()->

        $pair = Pair::from(new ValueObjectA('a'), new ValueObjectB('b'));

        $this->assertEquals('a', $pair->first()->getA());
        $this->assertEquals('b', $pair->second()->getB());
    }
}
