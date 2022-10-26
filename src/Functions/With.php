<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @param mixed[] $parameters
 * @return Closure(callable): mixed
 */
function with(...$parameters): Closure
{
    return static fn(callable $callback) => $callback(...$parameters);
}
