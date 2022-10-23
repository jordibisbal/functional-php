<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $initial, mixed $value, mixed $index, mixed $collection): mixed $callback
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function reduce(iterable $collection, callable $callback, mixed $initial = null): mixed
{
    foreach ($collection as $index => $value) {
        $initial = $callback($initial, $value, $index, $collection);
    }

    return $initial;
}
