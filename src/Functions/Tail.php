<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;
use function is_null as isNull;

/**
 * @template T
 * @phpstan-param iterable<T> $collection
 * @phpstan-param Closure(T, string|int): bool $predicate
 * @phpstan-return array<T>
 */
function tail(iterable $collection, Closure $predicate = null): array
{
    return match (true) {
        !isNull($predicate) => tail(select($collection, $predicate)),
        default => array_slice((array) $collection, 1, preserve_keys: true),
    };
}
