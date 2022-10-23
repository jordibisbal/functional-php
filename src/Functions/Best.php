<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection
 * @phpstan-param callable(mixed $first, mixed $second): int $callback
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function best(iterable $collection, callable $callback, mixed $default = null): mixed
{
    return fold(
        $collection,
        function ($value, $initial) use ($callback) {
            return $callback($value, $initial) > 0 ? $value : $initial;
        },
        $default
    );
}
