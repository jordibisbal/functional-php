<?php

declare(strict_types=1);

namespace j45l\functional;

use Throwable;

/**
 * @template T of Throwable
 * @param T $throwable
 * @throws T
 */
function tryOrThrow(callable $callable, $throwable): void
{
    try {
        $callable();
    } catch (Throwable $caughtThrowable) {
        throw $throwable;
    }
}