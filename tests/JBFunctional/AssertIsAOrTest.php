<?php
declare(strict_types=1);

namespace JBFunctional\Tests;

use Closure;
use Exception;
use JBFunctional\Stubs\AChildClass;
use JBFunctional\Stubs\AClass;
use PHPUnit\Framework\TestCase;
use Throwable;
use function JBFunctional\assertIsAOr;
use function JBFunctional\doOr;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class AssertIsAOrTest extends TestCase
{
    public function testTheFailHandlerFunctionIsCalledWhenTypeDoesNotMatch(): void
    {
        $called = false;

        assertIsAOr('object', $this->setTrue($called))('string');

        assertTrue($called);
    }

    public function testTheFailHandlerFunctionIsNotCalledWhenTypeMatch(): void
    {
        $called = false;

        assertIsAOr(AClass::class, $this->setTrue($called))(new AClass());

        assertFalse($called);
    }

    public function testTheFailHandlerFunctionIsNotCalledWhenParentTypeMatch(): void
    {
        $called = false;

        assertIsAOr(
            AClass::class,
            $this->setTrue($called)
        )(new AChildClass());

        assertFalse($called);
    }

    public function setTrue(bool &$called): Closure
    {
        return function () use (&$called): void {
            $called = true;
        };
    }
}
