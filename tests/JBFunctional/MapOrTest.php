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
        self::assertSame(['0value', '1value'], mapOr($fn, $this->uncalledThrowable())($this->list));
        self::assertSame(['0value', '1value'], mapOr($fn, $this->uncalledThrowable())($this->listIterator));
        self::assertSame(['k1' => 'k1val1', 'k2' => 'k2val2'], mapOr($fn, $this->uncalledThrowable())($this->hash));
        self::assertSame(
            ['k1' => 'k1val1', 'k2' => 'k2val2'],
            mapOr($fn, $this->uncalledThrowable())($this->hashIterator)
        );
    }

    public function testExceptionIsThrownInArray(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr([$this, 'exception'], $this->uncalledThrowable())($this->list);
    }

    public function testExceptionIsThrownInHash(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr([$this, 'exception'], $this->uncalledThrowable())($this->hash);
    }

    public function testExceptionIsThrownInIterator(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr([$this, 'exception'], $this->uncalledThrowable())($this->listIterator);
    }

    public function testExceptionIsThrownInHashIterator(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage('must be of type callable, array given,');
        mapOr([$this, 'exception'], $this->uncalledThrowable())($this->hashIterator);
    }

    public function testPassNoCollection(): void
    {
        $this->expectException('TypeError');
        $this->expectExceptionMessage(
            'must be of type Traversable|array, string given'
        );

        mapOr('strlen', $this->uncalledThrowable())('invalidCollection');
    }

    public function testTheFailHandlerFunctionIsCalledWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            ['exception'],
            mapOr($this->failingFunction(), fn() => 'exception')(['foo'])
        );
    }

    public function testTheFailHandlerFunctionIsCalledWithThrowableObjectWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            ['Exception thrown'],
            mapOr($this->failingFunction(), fn(Throwable $throwable) => $throwable->getMessage())(['foo'])
        );
    }

    public function testTheFailHandlerFunctionIsCalledWithCardinalParametersWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            ['Failing foo'],
            mapOr(
                $this->failingFunction(),
                fn(Throwable $throwable, string $value) => sprintf("Failing %s", $value)
            )(['foo'])
        );
    }

    public function testWhenFailingForAGivenElementTheOtherOnesAreReturnedAsExpected(): void
    {
        self::assertEquals(
            ['foo', 'Failing bar'],
            mapOr(
                $this->failingForFunction('bar'),
                fn(Throwable $throwable, string $value) => sprintf("Failing %s", $value)
            )(['foo', 'bar'])
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

    private function failingForFunction(string $failingValue): Closure
    {
        return static function ($value) use ($failingValue) {
            if ($value !== $failingValue) {
                return $value;
            }

            throw new RuntimeException('No throwable expected at this point');
        };
    }
}
