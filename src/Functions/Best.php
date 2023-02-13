<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @phpstan-param iterable<mixed> $collection
 * @phpstan-param Closure(mixed $first, mixed $second): bool $criteria
 */
function best(iterable $collection, Closure $criteria, mixed $default = null): mixed
{
    return fold(
        $collection,
        function ($value, $initial) use ($criteria) {
            return $criteria($value, $initial) ? $value : $initial;
        },
        $default
    );
}
