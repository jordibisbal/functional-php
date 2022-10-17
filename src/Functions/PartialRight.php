<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;
use function array_merge;
use function Functional\partial_right;

/**
 * @param mixed $arguments
 */
function partial(callable $callback, ...$arguments): Closure
{
    return static fn(...$innerArguments) => $callback(...array_merge($innerArguments, $arguments));
}
