<?php

declare(strict_types=1);

namespace j45l\functional;

use function array_pop as arrayPop;
use function is_array as isArray;
use function iterator_to_array as iteratorToArray;

/**
 * @param iterable<mixed> $collection
 * @return array<mixed>
 */
function butLast(iterable $collection): array
{
    $butLast = isArray($collection) ? $collection : iteratorToArray($collection);
    arrayPop($butLast);

    return $butLast;
}
