<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @param mixed[] $parameters
 */
function apply(callable $callback, ...$parameters): Closure
{
    return function () use ($callback, $parameters) {
        return $callback(...$parameters);
    };
}
