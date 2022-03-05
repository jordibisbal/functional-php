<?php

declare(strict_types=1);

namespace j45l\functional\Test\Unit;

use Exception;
use PHPUnit\Framework\TestCase;

use function j45l\functional\tryOr;
use function PHPUnit\Framework\assertEquals;

class TryOrTest extends TestCase
{
    public function testWhenNoExceptionReturnsValue(): void
    {
        assertEquals(42, tryOr(fn() => 42, 0));
    }

    public function testWhenExceptionReturnsAlternative(): void
    {
        assertEquals(12, tryOr(fn() => throw new Exception(), 12));
    }

    /** @noinspection PhpDivisionByZeroInspection */
    public function testWhenErrorReturnsAlternative(): void
    {
        /** @phpstan-ignore-next-line */
        assertEquals(12, tryOr(fn() => 1 / 0, 12));
    }
}
