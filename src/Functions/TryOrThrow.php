<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;
use Throwable;

/**
 * @template T of Throwable
 * @template T2
 * @param Closure():T2 $function
 * @param T $throwable
 * @return T2
 * @throws T
 */
function tryOrThrow(Closure $function, $throwable): mixed
{
    try {
        return $function();
    } catch (Throwable $caughtThrowable) {
        throw $throwable;
    }
}
