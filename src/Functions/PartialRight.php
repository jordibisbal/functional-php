<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function array_merge as arrayMerge;

/**
 * @param mixed $arguments
 */
function partialRight(callable $callback, ...$arguments): Closure
{
    return static fn(...$innerArguments) => $callback(...arrayMerge($innerArguments, $arguments));
}
