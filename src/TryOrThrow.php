<?php

declare(strict_types=1);

namespace j45l\functional;

use Throwable;

/**
 * @throws Throwable
 */
function tryOrThrow(callable $callable, Throwable $throwable): void
{
    try {
        $callable();
    } catch (Throwable $caughtThrowable) {
        throw $throwable;
    }
}