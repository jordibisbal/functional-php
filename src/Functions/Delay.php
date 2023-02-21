<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @phpstan-param float $seconds
 * @phpstan-param Closure():T $callable
 * @phpstan-param Closure(float):void $delayFn
 * @phpstan-return T
 */
function delay(float $seconds, Closure $callable, Closure $delayFn = null): mixed
{
    $delayFn ??= static fn (float $seconds) => usleep((int)($seconds * 1E6));

    $delayFn($seconds);

    return $callable();
}
