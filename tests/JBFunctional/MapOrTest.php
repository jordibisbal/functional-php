<?php
declare(strict_types=1);

namespace JBFunctional\Tests;

use ArrayIterator;
use Closure;
use Exception;
use Functional\Exceptions\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use function JBFunctional\mapOr;

class MapOrTest extends TestCase
{
    private array $list;
    private ArrayIterator $listIterator;
    private array $hash;
    private ArrayIterator $hashIterator;

    public function setUp(): void
    {
        parent::setUp();
        $this->list = ['value', 'value'];
        $this->listIterator = new ArrayIterator($this->list);
        $this->hash = ['k1' => 'val1', 'k2' => 'val2'];
        $this->hashIterator = new ArrayIterator($this->hash);
    }

    public function test(): void
    {
        $fn = function ($v, $k, $collection) {
            InvalidArgumentException::assertCollection($collection, __FUNCTION__, 3);
            return $k . $v;
        };
        self::assertSame(['0value', '1value'], mapOr($this->list, $fn, $this->uncalledThrowable()));
        self::assertSame(['0value', '1value'], mapOr($this->listIterator, $fn, $this->uncalledThrowable()));
        self::assertSame(['k1' => 'k1val1', 'k2' => 'k2val2'], mapOr($this->hash, $fn, $this->uncalledThrowable()));
        self::assertSame(
            ['k1' => 'k1val1', 'k2' => 'k2val2'],
            mapOr($this->hashIterator, $fn, $this->uncalledThrowable())
        );
    }

    public function testExceptionIsThrownInArray(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr($this->list, [$this, 'exception'], $this->uncalledThrowable());
    }

    public function testExceptionIsThrownInHash(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr($this->hash, [$this, 'exception'], $this->uncalledThrowable());
    }

    public function testExceptionIsThrownInIterator(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr($this->listIterator, [$this, 'exception'], $this->uncalledThrowable());
    }

    public function testExceptionIsThrownInHashIterator(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr($this->hashIterator, [$this, 'exception'], $this->uncalledThrowable());
    }

    public function testPassNoCollection(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage(
            'must be of type Traversable|array, string given'
        );

        mapOr('invalidCollection', 'strlen', $this->uncalledThrowable());
    }

    public function testPassNonCallable(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('Argument #2 ($callback) must be of type callable, string given,');

        mapOr($this->list, 'undefinedFunction', $this->uncalledThrowable());
    }


    public function testTheFailHandlerFunctionIsCalledWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            ['exception'],
            mapOr(['foo'], $this->failingFunction(), fn() => 'exception')
        );
    }

    public function testTheFailHandlerFunctionIsCalledWithThrowableObjectWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            ['Exception thrown'],
            mapOr(['foo'], $this->failingFunction(), fn(Throwable $throwable) => $throwable->getMessage())
        );
    }

    public function testTheFailHandlerFunctionIsCalledWithCardinalParametersWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            ['Failing foo'],
            mapOr(
                ['foo'],
                $this->failingFunction(),
                fn(Throwable $throwable, string $value) => sprintf("Failing %s", $value)
            )
        );
    }

    public function testWhenFailingForAGivenElementTheOtherOnesAreReturnedAsExpected(): void
    {
        self::assertEquals(
            ['foo', 'Failing bar'],
            mapOr(
                ['foo', 'bar'],
                $this->failingForFunction('bar'),
                fn(Throwable $throwable, string $value) => sprintf("Failing %s", $value)
            )
        );
    }

    private function failingFunction(): Closure
    {
        return static function () {
            throw new Exception('Exception thrown');
        };
    }

    private function uncalledThrowable(): Closure
    {
        return static function () {
            throw new RuntimeException('No throwable expected at this point');
        };
    }

    private function failingForFunction(string $failingValue)
    {
        return static function ($value) use ($failingValue) {
            if ($value !== $failingValue) {
                return $value;
            }

            throw new RuntimeException('No throwable expected at this point');
        };
    }
}
