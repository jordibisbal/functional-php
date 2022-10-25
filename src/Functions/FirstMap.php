<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @template T2
 * @param iterable<T> $collection Collection
 * @param callable(T, mixed=, iterable<T>=):T2 $map
 * @param (callable(T2, mixed=, iterable<T>=):bool)|null $predicate
 * @param T2|null $default
 * @return T2|null
 */
function firstMap(iterable $collection, callable $map, callable $predicate = null, mixed $default = null): mixed
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
