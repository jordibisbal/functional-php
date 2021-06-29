<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;

function assertIsAOr(string $fn, Callable $failFn): Closure
{
    return static function ($item) use ($fn, $failFn): void
    {
        if (is_a($item, $fn)) {
            return;
        }

        $failFn($item, $fn);
    };
}

