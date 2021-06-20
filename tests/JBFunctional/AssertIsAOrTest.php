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
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertTrue;

class AssertIsAOrTest extends TestCase
{
    public function testTheFailHandlerFunctionIsCalledWhenTypeDoesNotMatch(): void
    {
        $parameters = [];

        assertIsAOr('object', $this->setCallParametersInto($parameters))('string');

        assertEquals(['string', 'object'],$parameters);
    }

    public function testTheFailHandlerFunctionIsNotCalledWhenTypeMatch(): void
    {
        $parameters = [];

        assertIsAOr(AClass::class, $this->setCallParametersInto($parameters))(new AClass());

        assertEquals([],$parameters);
    }

    public function testTheFailHandlerFunctionIsNotCalledWhenParentTypeMatch(): void
    {
        $parameters = [];

        assertIsAOr(
            AClass::class,
            $this->setCallParametersInto($parameters)
        )(new AChildClass());

        assertEquals([],$parameters);
    }

    public function setCallParametersInto(&$parametersBag): Closure
    {
        return function (...$parameters) use (&$parametersBag): void {
            $parametersBag = $parameters;
        };
    }
}
