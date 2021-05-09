<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;

function invokeOr(Callable $fn, Callable $failFn): Closure
{
    return static function (...$params) use ($fn, $failFn)
    {
        try {
            return $fn(...$params);
        } catch (\Throwable $throwable) {
            return $failFn($throwable, ...$params);
        }
    };
}

