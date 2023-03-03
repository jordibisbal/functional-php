<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @param mixed[] $parameters
 * @return Closure(...Closure): mixed
 */
function with(...$parameters): Closure
{
    return static function (Closure ...$fns) use ($parameters) {
        $result = null;

        foreach ($fns as $callback) {
            $result = $callback(...$parameters);
        }

        return $result;
    };
}
