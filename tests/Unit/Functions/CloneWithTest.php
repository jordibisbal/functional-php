<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit\Functions;

use PHPUnit\Framework\TestCase;

use function j45l\functional\cloneWith;

class CloneWithTest extends TestCase
{
    public function testCanCloneChangingPrivateProperties(): void
    {
        $target = new class () {
            private int $meaningOfLife = 1;
            public function meaning(): int
            {
                return $this->meaningOfLife;
            }
        };

        $clone = cloneWith($target, fn ($newTarget) => $newTarget->meaningOfLife = 42);

        self::assertEquals(42, $clone->meaning());
        self::assertNotSame($target, $clone);
    }
}
