<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @template T2
 * @phpstan-param iterable<T> $collection Collection
 * @phpstan-param Closure(T, mixed=, iterable<T>=): bool $predicate
 * @phpstan-param T2 $default
 * @phpstan-return ($collection is non-empty-array<T> ? T : T2|null)
 */
function head(iterable $collection, Closure $predicate = null, mixed $default = null): mixed
{
    return first($collection, $predicate, $default);
}
