<?php

namespace j45l\functional\Test\Unit\Functions;

use _PHPStan_156cb69be\Symfony\Component\Console\Exception\LogicException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
use function j45l\functional\tryOrThrow;

final class TryOrThrowTest extends TestCase
{
    /**
     * @throws Throwable
     */
    public function testThrowsNothingWhenNoException(): void
    {
        tryOrThrow(function () {
        }, new RuntimeException('Thrown exception'));

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
}
