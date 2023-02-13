<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function Functional\head;
use function Functional\tail;

/**
 * @template T
 * @template T2
 * @param iterable<T> $collection Collection
 * @param Closure(T $value, int|string $key, iterable<T> $collection):T2 $function
 * @return array<T2>
 */
function map(iterable $collection, Closure $function): array
{
    $aggregation = [];

    foreach ($collection as $key => $value) {
        $aggregation[$key] = $function($value, $key, $collection);
    }

    return $aggregation;
}
