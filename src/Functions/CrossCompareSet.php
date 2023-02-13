<?php

namespace j45l\functional;

use Traversable;
use j45l\functional\Tuples\Pair;
use function iterator_to_array as iteratorToArray;

/**
 * @param iterable<mixed> $collection
 * @return Pair<mixed, mixed>[]
 * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function crossCompareSet(iterable $collection): array
{
    $collection = unindex($collection instanceof Traversable ? iteratorToArray($collection) : $collection);
    $aggregation = [];

    foreach (range(0, count($collection) - 2) as $i) {
        foreach (range($i + 1, count($collection) - 1) as $j) {
            $aggregation[] = Pair::from($collection[$i], $collection[$j]);
        }
    }

    return $aggregation;
}
