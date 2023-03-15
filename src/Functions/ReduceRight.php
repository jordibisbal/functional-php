<?php

declare(strict_types=1);

namespace j45l\functional;

use function is_null as isNull;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $initial, mixed $value, mixed $index, mixed $collection): mixed $fn
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function reduceRight(iterable $collection, callable $fn, mixed $initial = null): mixed
{
    end($collection);
    while (!isNull(key($collection))) {
        $initial = $fn($initial, current($collection), key($collection), $collection);
        prev($collection);
    }

    return $initial;
}
