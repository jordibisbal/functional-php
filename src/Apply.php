<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @param mixed[] $appliedParameters
 */
function apply(callable $callback, ...$appliedParameters): Closure
{
    return function (...$parameters) use ($callback, $appliedParameters) {
        return $callback(...$parameters, ...$appliedParameters);
    };
}
