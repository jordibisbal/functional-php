<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use ArrayIterator;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\select;

#[CoversFunction('j45l\functional\select')]
class SelectTest extends TestCase
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
    public function test(): void
    {
        $callback = static fn($value, $key, $collection) => $value === 'value' && $key !== '';

        self::assertSame(['value', 2 => 'value'], select($this->list, $callback));
        self::assertSame(['value', 2 => 'value'], select($this->listIterator, $callback));
        self::assertSame(['k1' => 'value', 'k3' => 'value'], select($this->hash, $callback));
        self::assertSame(['k1' => 'value', 'k3' => 'value'], select($this->hashIterator, $callback));
    }

    public function testPassNoCallable(): void
    {
        self::assertSame(['value', 'wrong', 'value'], select($this->list));
        self::assertSame(['value', 'wrong', 'value'], select($this->listIterator));
        self::assertSame(['k1' => 'value', 'k2' => 'wrong', 'k3' => 'value'], select($this->hash));
        self::assertSame(['k1' => 'value', 'k2' => 'wrong', 'k3' => 'value'], select($this->hashIterator));
        self::assertSame([0 => true, 2 => true], select([true, false, true]));
    }
}
