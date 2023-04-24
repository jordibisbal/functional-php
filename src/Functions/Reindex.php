<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @template T2 of (int|string)
 * @param iterable<T> $collection Collection
 * @param Closure(T2 $key, T $value, iterable<T> $collection):T2 $function
 * @return array<T>
 */
function reindex(iterable $collection, Closure $function): array
{
    $aggregation = [];

    foreach ($collection as $key => $value) {
        $aggregation[$function($key, $value, $collection)] = $value;
    }

    return $aggregation;
}
