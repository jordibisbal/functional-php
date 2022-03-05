<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use ArrayIterator;
use PHPUnit\Framework\TestCase;

use function strlen;

class SelectTest extends TestCase
{
    /**
     * @return string[][]
     */
    public function getAliases(): array
    {
        return [
            ['j45l\functional\select'],
            ['j45l\functional\filter'],
        ];
    }

    /**
     * @dataProvider getAliases
     */
    public function test(callable $functionName): void
    {
        $callback = fn (string $v, string|int $k) => ($v == 'value') && (strlen((string) $k) > 0);

        self::assertSame(['value', 2 => 'value'], $functionName($this->buildList(), $callback));
        self::assertSame(['value', 2 => 'value'], $functionName($this->buildListIterator(), $callback));
        self::assertSame(['k1' => 'value', 'k3' => 'value'], $functionName($this->buildHash(), $callback));
        self::assertSame(['k1' => 'value', 'k3' => 'value'], $functionName($this->buildHashIterator(), $callback));
    }

    /**
     * @return string[]
     */
    public function buildList(): array
    {
        return ['value', 'wrong', 'value'];
    }

    /**
     * @return ArrayIterator<integer,string>
     */
    public function buildListIterator(): ArrayIterator
    {
        return new ArrayIterator($this->buildList());
    }

    /**
     * @return string[]
     * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
     */
    public function buildHash(): array
    {
        return ['k1' => 'value', 'k2' => 'wrong', 'k3' => 'value'];
    }

    /**
     * @return ArrayIterator<string, string>
     */
    public function buildHashIterator(): ArrayIterator
    {
        return new ArrayIterator($this->buildHash());
    }
}
