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
function last(iterable $collection, Closure $predicate = null, mixed $default = null): mixed
{
    $predicate ??= static fn () => true;
    $match = null;
    $found = false;

    foreach ($collection as $key => $element) {
        /** @noinspection PhpMethodParametersCountMismatchInspection */
        if ($predicate($element, $key, $collection)) {
            $found = true;
            $match = $element;
        }
    }

    return match (true) {
        $found => $match,
        default => $default
    };
}
