<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function j45l\functional\cloneWith;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotSame;

#[CoversFunction('j45l\functional\cloneWith')]
class CloneWithTest extends TestCase
{
    public function testCanCloneChangingPrivateProperties(): void
    {
        $target = $this->targetObject();

        $clone = cloneWith($target, fn ($newTarget) => $newTarget->meaningOfLife = 42);

        assertEquals(1, $target->meaning());
        assertEquals(42, $clone->meaning());
        assertNotSame($target, $clone);
    }

    public function targetObject(): Target
    {
        return new class () implements Target {
            private int $meaningOfLife = 1;

            public function meaning(): int
            {
                return $this->meaningOfLife;
            }
        };
    }
}

interface Target // phpcs:ignore
{
    public function meaning(): int;
}
