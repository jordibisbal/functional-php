<?php

namespace j45l\functional\Test\Unit\Tuples;

use j45l\functional\Test\Unit\Fixtures\ValueObjectA;
use j45l\functional\Test\Unit\Fixtures\ValueObjectB;
use j45l\functional\Test\Unit\Fixtures\ValueObjectC;
use j45l\functional\Tuples\Triplet;
use PHPUnit\Framework\TestCase;

use function j45l\functional\Tuples\Triplet;

/**
 * @covers \j45l\functional\Tuples\Triplet
 * @covers ::\j45l\functional\Tuples\Triplet
 */
class TripletTest extends TestCase
{
    public function testATripletCanBeCreateFromThreePrimitives(): void
    {
        $triplet = Triplet::from(1, '2', 3);

        $this->assertEquals(1, $triplet->first());
        $this->assertEquals('2', $triplet->second());
        $this->assertEquals(3, $triplet->third());
    }

    public function testATripletValueCanBeRetrievedAsArray(): void
    {
        $triplet = Triplet(1, '2', 3);

        $this->assertEquals([1, '2', 3], $triplet->toArray());
    }

    public function testATripletCanBeCreateFromThreeObjects(): void
    {
        // This test in fact helps to debug issues with template (generics) rendering within phpstorm
        // Try autocompletion and type validation on $three->first()->

        $triplet = Triplet::from(new ValueObjectA('a'), new ValueObjectB('b'), new ValueObjectC('c'));

        $this->assertEquals('a', $triplet->first()->getA());
        $this->assertEquals('b', $triplet->second()->getB());
        $this->assertEquals('c', $triplet->third()->getC());
    }
}
