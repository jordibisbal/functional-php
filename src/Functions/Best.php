<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @phpstan-param iterable<mixed> $collection
 * @phpstan-param Closure(mixed $first, mixed $second): bool $bestPredicate
 */
function best(iterable $collection, Closure $bestPredicate, mixed $default = null): mixed
{
    return fold(
        $collection,
        function ($value, $initial) use ($bestPredicate) {
            return $bestPredicate($value, $initial) ? $value : $initial;
        },
        $default
    );
}
