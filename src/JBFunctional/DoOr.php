<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;

function doOr(Callable $fn, Callable $failFn): Closure
{
    return static function (mixed ...$params) use ($fn, $failFn): mixed
    {
        try {
            return $fn(...$params);
        } catch (\Throwable $throwable) {
            return $failFn($throwable, ...$params);
        }
    };
}

