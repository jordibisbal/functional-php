<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @phpstan-param float $seconds
 * @phpstan-param callable():T $callable
 * @phpstan-param callable(float):void $delayFn
 * @phpstan-return T
 */
function delay(float $seconds, callable $callable, callable $delayFn = null)
{
    $delayFn ??= static fn (float $seconds) => usleep((int)($seconds * 1E6));

    $delayFn($seconds);

    return $callable();
}
