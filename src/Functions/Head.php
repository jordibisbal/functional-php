<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @template T2
 * @phpstan-param iterable<T> $collection Collection
 * @phpstan-param T2 $default
 * @phpstan-return ($collection is non-empty-array<T> ? T : T2|null)
 */
function head(iterable $collection, mixed $default = null): mixed
{
    foreach ($collection as $item) {
        return $item;
    }

    return $default;
}
