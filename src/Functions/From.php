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
function from(iterable $collection, Closure $predicate = null): array
{
    $predicate ??= static fn (mixed $x, $_1, $_2) => (bool) $x;

    $aggregate = [];
    $capture = false;

    foreach ($collection as $index => $element) {
        $capture |= $predicate($element, $index, $collection);
        if ($capture) {
            $aggregate [$index] = $element;
        }
    }

    return $aggregate;
}
