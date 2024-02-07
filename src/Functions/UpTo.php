<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @phpstan-param iterable<T> $collection Collection
 * @phpstan-param Closure(T, mixed, iterable<T>): bool $predicate
 * @phpstan-return array<T>
 * @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function upTo(iterable $collection, Closure $predicate = null): array
{
    $predicate ??= static fn (mixed $x, $_1, $_2) => (bool) $x;

    $aggregate = [];

    foreach ($collection as $index => $element) {
        $aggregate[$index] = $element;
        if ($predicate($element, $index, $collection)) {
            return $aggregate;
        }
    }

    return $aggregate;
}
