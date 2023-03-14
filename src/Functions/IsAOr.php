<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function is_a as isA;

/**
 * @template T
 * @template T2
 * @param class-string<T> $className
 * @param T2 $default
 * @return T|T2
 */
function isAOr(mixed $value, string $className, mixed $default = null): mixed
{
    return isA($value, $className)
        ? $value
        : match (true) {
            $default instanceof Closure => $default($value),
            default => $default
        };
}
