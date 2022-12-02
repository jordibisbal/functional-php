<?php

declare(strict_types=1);

namespace j45l\functional;

use j45l\functional\Tuples\Pair;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $initial, mixed $value, mixed $index, mixed $collection): mixed $callback
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function reduceRight(iterable $collection, callable $callback, mixed $initial = null): mixed
{
    foreach (array_reverse(Pair::arrayFromIndexed($collection)) as $pair) {
        $initial = $callback($initial, $pair->second(), $pair->first(), $collection);
    }

    return $initial;
}
