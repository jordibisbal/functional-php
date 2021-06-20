<?php

declare(strict_types=1);

namespace JBFunctional;

use Closure;

function assertIsAOr(string $className, Callable $failFn): Closure
{
    return static function ($item) use ($className, $failFn): void
    {
        if (is_a($item, $className)) {
            return;
        }

        $failFn($item);
    };
}

