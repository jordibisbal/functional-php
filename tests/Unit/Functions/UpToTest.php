<?php

declare(strict_types = 1);

namespace j45l\functional\Test\Unit\Functions;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\trueFn;
use function j45l\functional\upTo;

#[CoversFunction('j45l\functional\upTo')]
class UpToTest extends TestCase
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

        self::assertSame(['value', 'wrong'], upTo($this->list, $callback));
        self::assertSame(['value', 'wrong'], upTo($this->listIterator, $callback));
    }

    public function testEmptyCollection(): void
    {
        self::assertSame([], upTo([], trueFn(...)));
        self::assertSame([], upTo(new ArrayIterator([]), trueFn(...)));
    }

    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testHash(): void
    {
        $callback = static fn ($value, $key, $collection) => $key === 'k2';

        self::assertSame(['k1'=> 'value', 'k2'=> 'wrong'], upTo($this->hash, $callback));
        self::assertSame(['k1'=> 'value', 'k2'=> 'wrong'], upTo($this->hashIterator, $callback));
    }

    public function testPassNoCallableSelectsUpToFirstTruthy(): void
    {
        self::assertSame(['value'], upTo($this->list));
        self::assertSame(['value'], upTo($this->listIterator));
        self::assertSame(['k1' => 'value'], upTo($this->hash));
        self::assertSame(['k1' => 'value'], upTo($this->hashIterator));
        self::assertSame([true], upTo([true, false, true]));
        self::assertSame([false, true], upTo([false, true, true]));
    }
}
