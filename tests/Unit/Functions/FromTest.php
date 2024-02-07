<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use function j45l\functional\from;

#[CoversFunction('j45l\functional\from')]
class FromTest extends TestCase
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

        $this->list = ['value', 'wrong', 'value'];
        $this->listIterator = new ArrayIterator($this->list);
        $this->hash = ['k1' => 'value', 'k2' => 'wrong', 'k3' => 'value'];
        $this->hashIterator = new ArrayIterator($this->hash);
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testList(): void
    {
        $callback = static fn ($value, $key, $collection) => $value === 'wrong';

        self::assertSame([1 => 'wrong', 2 => 'value'], from($this->list, $callback));
        self::assertSame([1 => 'wrong', 2 => 'value'], from($this->listIterator, $callback));
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testHash(): void
    {
        $callback = static fn ($value, $key, $collection) => $key === 'k2';

        self::assertSame(['k2' => 'wrong', 'k3' => 'value'], from($this->hash, $callback));
        self::assertSame(['k2' => 'wrong', 'k3' => 'value'], from($this->hashIterator, $callback));
    }

    public function testPassNoCallable(): void
    {
        self::assertSame([0 => 'value', 1 => 'wrong', 2 => 'value'], from($this->list));
        self::assertSame([0 => 'value', 1 => 'wrong', 2 => 'value'], from($this->listIterator));
        self::assertSame(['k1' => 'value', 'k2' => 'wrong', 'k3' => 'value'], from($this->hash));
        self::assertSame(['k1' => 'value', 'k2' => 'wrong', 'k3' => 'value'], from($this->hashIterator));
        self::assertSame([0 => true, 1 => false, 2 => true], from([true, false, true]));
        self::assertSame([1 => true, 2 => false], from([false, true, false]));
    }
}
