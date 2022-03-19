<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param callable(mixed $value, mixed $index, mixed $collection, mixed $initial): mixed $callback
 * @param         null|mixed $initial
 * @return        mixed|null
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function reduceRight(iterable $collection, callable $callback, $initial = null)
{
    foreach (array_reverse(Pair::arrayFromIndexed($collection)) as $pair) {
        $initial = $callback($pair->second(), $pair->first(), $collection, $initial);
    }

    return $initial;
}
