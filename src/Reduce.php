<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $value, mixed $index, mixed $collection, mixed $initial): mixed $callback
 * @param         null|mixed $initial
 * @return        mixed
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function reduce(iterable $collection, callable $callback, mixed $initial = null): mixed
{
    foreach ($collection as $index => $value) {
        $initial = $callback($value, $index, $collection, $initial);
    }

    return $initial;
}
