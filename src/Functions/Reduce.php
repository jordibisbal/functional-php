<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param Closure(mixed $initial, mixed $value, mixed $index, mixed $collection): mixed $fn
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function reduce(iterable $collection, Closure $fn, mixed $initial = null): mixed
{
    foreach ($collection as $index => $value) {
        $initial = $fn($initial, $value, $index, $collection);
    }

    return $initial;
}
