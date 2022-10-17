<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @param mixed[] $parameters
 */
function with(callable $callback, ...$parameters): Closure
{
    return static fn() => $callback(...$parameters);
}
