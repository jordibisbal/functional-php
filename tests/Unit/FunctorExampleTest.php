<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use j45l\functional\Cats\Functors\Functor;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

final class FunctorExampleTest extends TestCase
{
    /** @SuppressWarnings(PHPMD.UnusedFormalParameter) */
    public function testAdder(): void
    {
        $functor = new class (41) implements Functor {
            public readonly int $value;

            public function __construct(int $value)
            {
                $this->value = $value;
            }

            public function map(callable $fn): Functor
            {
                return new self($fn($this->value));
            }
        };

        /** @noinspection PhpPossiblePolymorphicInvocationInspection */
        /** @phpstan-ignore-next-line  */
        assertEquals(42, $functor->map(fn ($x) => $x + 1)->value);
    }
}
