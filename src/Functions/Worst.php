<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection
 * @phpstan-param callable(mixed $first, mixed $second): bool $bestPredicate
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function worst(iterable $collection, callable $bestPredicate, mixed $default = null): mixed
{
    return foldRight(
        $collection,
        function ($value, $acc) use ($bestPredicate) {
            return !$bestPredicate($value, $acc) ? $value : $acc;
        },
        $default
    );
}
