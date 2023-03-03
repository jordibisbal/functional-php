<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use ArrayIterator;
use PHPUnit\Framework\TestCase;

use function j45l\functional\reject;

/** @covers ::\j45l\functional\reject() */
class RejectTest extends TestCase
{
    /** @var Array<mixed> */
    private array $list;
    /** @var ArrayIterator<int, mixed>  */
    private ArrayIterator $listIterator;
    /** @var string[] */
    private array $hash;
    /** @var ArrayIterator<string, mixed>  */
    private ArrayIterator $hashIterator;

    public function setUp(): void
    {
        parent::setUp();

        $this->list = ['value', 'correct', 'value'];
        $this->listIterator = new ArrayIterator($this->list);
        $this->hash = ['k1' => 'value', 'k2' => 'correct', 'k3' => 'correct'];
        $this->hashIterator = new ArrayIterator($this->hash);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function test(): void
    {
        $predicate = static fn($value, $key, $collection) => $value === 'value' || $key === 'k2';

        self::assertSame([1 => 'correct'], reject($this->list, $predicate));
        self::assertSame([1 => 'correct'], reject($this->listIterator, $predicate));
        self::assertSame(['k3' => 'correct'], reject($this->hash, $predicate));
        self::assertSame(['k3' => 'correct'], reject($this->hashIterator, $predicate));
    }

    public function testPassNoCallable(): void
    {
        self::assertSame([], reject($this->list));
        self::assertSame([], reject($this->listIterator));
        self::assertSame([], reject($this->hash));
        self::assertSame([], reject($this->hashIterator));
        self::assertSame([1 => false], reject([true, false, true]));
    }
}
