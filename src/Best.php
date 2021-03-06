<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection
 * @phpstan-param callable(mixed $first, mixed $second): int $callback
 * @param         mixed|null $default
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function best(iterable $collection, callable $callback, $default = null)
{
    return fold(
        $collection,
        function ($value, $initial) use ($callback) {
            return $callback($value, $initial) > 0 ? $value : $initial;
        },
        $default
    );
}
