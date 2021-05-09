<?php
declare(strict_types=1);

namespace JBFunctional\Tests;

use Closure;
use Exception;
use PHPUnit\Framework\TestCase;
use Throwable;
use function JBFunctional\invokeOr;

class InvokeOrTest extends TestCase
{
    public function testTheCardinalFunctionReturnValueIsReturned(): void
    {
        self::assertEquals('expectedString', invokeOr(fn() => 'expectedString', fn() => null)());
    }

    public function testTheCardinalFunctionIsCalledWithParameters(): void
    {
        self::assertEquals(
            'expectedString',
            invokeOr(fn($param) => $param, fn() => null)('expectedString')
        );
        self::assertEquals(
            'anotherExpectedString',
            invokeOr(fn($param) => $param, fn() => null)('anotherExpectedString')
        );
    }

    public function testTheFailHandlerFunctionIsCalledWhenAnExceptionIsThrown(): void
    {
        self::assertEquals('exception', invokeOr($this->failingFunction(), fn() => 'exception')());
    }

    public function testTheFailHandlerFunctionIsCalledWithThrowableObjectWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            'Exception thrown',
            invokeOr($this->failingFunction(), fn(Throwable $throwable) => $throwable->getMessage())()
        );
    }

    public function testTheFailHandlerFunctionIsCalledWithCardinalParametersWhenAnExceptionIsThrown(): void
    {
        self::assertEquals(
            'Failing expectedString',
            invokeOr(
                $this->failingFunction(),
                fn(Throwable $throwable, string $string) => sprintf("Failing %s", $string)
            )('expectedString')
        );
    }

    private function failingFunction(): Closure
    {
        return static function () {
            throw new Exception('Exception thrown');
        };
    }
}