<?php

use j45l\functional\Tuples\Pair;

/**
 * @param iterable<mixed> $collection
 * @return Pair<mixed, mixed>[]
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function crossCompareSet(iterable $collection): array
{
    $collection = $collection instanceof Traversable ? iterator_to_array($collection) : $collection;
    $aggregation = [];

    foreach (range(0, count($collection) - 2) as $i) {
        foreach (range($i + 1, count($collection) - 1) as $j) {
            $aggregation[] = Pair::from($collection[$i], $collection[$j]);
        }
    }

    return $aggregation;
}
