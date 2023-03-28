<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\tail;

#[CoversFunction('j45l\functional\tail')]
class TailTest extends TestCase
{
    /** @var int[] */
    private array $list;
    /** @var ArrayIterator<int, int>  */
    private ArrayIterator $listIterator;
    /** @var int[] */
    private array $badArray;
    /** @var ArrayIterator<int, int>  */
    private ArrayIterator $badIterator;

    public function setUp(): void
    {
        parent::setUp();
        $this->list = [1, 2, 3, 4];
        $this->listIterator = new ArrayIterator($this->list);
        $this->badArray = [-1, 0, 1];
        $this->badIterator = new ArrayIterator($this->badArray);
    }

    public function test(): void
    {
        $fn = static fn ($x): bool => $x > 2;

        self::assertSame([3 => 4], tail($this->list, $fn));
        self::assertSame([3 => 4], tail($this->listIterator, $fn));
        self::assertSame([], tail($this->badArray, $fn));
        self::assertSame([], tail($this->badIterator, $fn));
    }

    public function testWithoutCallback(): void
    {
        self::assertSame([1 => 2, 2 => 3, 3 => 4], tail($this->list));
        self::assertSame([1 => 2, 2 => 3, 3 => 4], tail($this->list));
        self::assertSame([1 => 2, 2 => 3, 3 => 4], tail($this->listIterator));
        self::assertSame([1 => 2, 2 => 3, 3 => 4], tail($this->listIterator));
        self::assertSame([1 => 0, 2 => 1], tail($this->badArray));
        self::assertSame([1 => 0, 2 => 1], tail($this->badArray));
        self::assertSame([1 => 0, 2 => 1], tail($this->badIterator));
        self::assertSame([1 => 0, 2 => 1], tail($this->badIterator));
    }
}
