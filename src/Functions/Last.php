<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @param iterable<T> $collection
 * @param (Closure(T=, array-key=, iterable<T>=):bool)|null $predicate
 * @return T|null
 */
function last(iterable $collection, Closure $predicate = null): mixed
{
    $predicate ??= static fn () => true;
    $match = null;
    foreach ($collection as $key => $element) {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        if ($predicate($element, $key, $collection)) {
            $match = $element;
        }
    }

    return $match;
}
