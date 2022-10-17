<?php

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;
use function j45l\functional\toArray;
use function j45l\functional\toGenerator;

class ToGeneratorTest extends TestCase
{
    public function testToGeneratorIsNotConsumedByCurrent(): void
    {
        $generator = toGenerator([1, 2, 3]);
        $this->assertEquals(1, $generator->current());
        $this->assertEquals(1, $generator->current());
    }

    public function testToGeneratorGetNext(): void
    {
        $generator = toGenerator([1, 2, 3]);
        $this->assertEquals(1, $generator->current());
        $generator->next();
        $this->assertEquals(2, $generator->current());
    }

    public function testToGeneratorGetAllElements(): void
    {
        $testArray = ['a' => 1, 2, 'c' => 3];
        $this->assertEquals($testArray, toArray(toGenerator($testArray)));
    }
}
