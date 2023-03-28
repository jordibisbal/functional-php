<?php

namespace j45l\functional\Test\Unit\Functions;

use LogicException;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;

use function j45l\functional\tryOrThrow;
use function PHPUnit\Framework\assertEquals;

#[CoversFunction('j45l\functional\tryOrThrow')]
final class TryOrThrowTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testThrowsNothingWhenNoException(): void
    {
        tryOrThrow(
            static function () {
            },
            new RuntimeException('Thrown exception')
        );

        $this->expectNotToPerformAssertions();
    }

    /**
     * @throws Throwable
     */
    public function testThrowsGivenExceptionWhenExcepts(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Thrown exception');

        tryOrThrow(
            function () {
                throw new LogicException('Original Exception');
            },
            new RuntimeException('Thrown exception')
        );
    }

    /**
     * @throws Throwable
     */
    public function testWhenNotThrowingReturnResult(): void
    {
        assertEquals(
            42,
            tryOrThrow(
                function (): int {
                    return 42;
                },
                new RuntimeException('Thrown exception')
            )
        );
    }
}
