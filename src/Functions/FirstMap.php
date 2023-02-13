<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @template T2
 * @param iterable<T> $collection Collection
 * @param Closure(T, mixed=, iterable<T>=):T2 $map
 * @param (Closure(T2, mixed=, iterable<T>=):bool)|null $predicate
 * @param T2|null $default
 * @return T2|null
 */
function firstMap(iterable $collection, Closure $map, Closure $predicate = null, mixed $default = null): mixed
{
    $predicate ??= trueFn(...);

    foreach ($collection as $index => $element) {
        $mapped = $map($element, $index, $collection);
        if ($predicate($mapped, $index, $collection)) {
            return $mapped;
        }
    }

    return $default;
}
