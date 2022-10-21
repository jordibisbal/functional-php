<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @template T2
 * @phpstan-param iterable<T> $collection Collection
 * @phpstan-param callable(T, mixed=, iterable<T>=): bool $predicate
 * @phpstan-param T2 $default
 * @return        T|T2|null
 */
function first(iterable $collection, callable $predicate = null, mixed $default = null): mixed
{
    $predicate ??= trueFn(...);

    foreach ($collection as $index => $element) {
        if ($predicate($element, $index, $collection)) {
            return $element;
        }
    }

    return $default;
}
