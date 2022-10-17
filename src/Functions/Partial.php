<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;
use function array_merge;

/**
 * @param mixed $arguments
 */
function partial(callable $callback, ...$arguments): Closure
{
    return static fn(...$innerArguments) => $callback(...array_merge($arguments, $innerArguments));
}