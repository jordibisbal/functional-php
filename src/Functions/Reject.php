<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @phpstan-param iterable<T> $collection Collection
 * @phpstan-param callable(T, mixed, iterable<T>): bool $predicate
 * @phpstan-return array<T>
 *  @SuppressWarnings(PHPMD.UnusedFormalParameter)
 */
function reject(iterable $collection, callable $predicate = null): array
{
    $predicate ??= static fn (mixed $x, $_1, $_2) => (bool) $x;

    $result = [];

    foreach ($collection as $index => $element) {
        if (!$predicate($element, $index, $collection)) {
            $result[$index] = $element;
        }
    }

    return $result;
}
