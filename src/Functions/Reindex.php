<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

/**
 * @template T
 * @param iterable<T> $collection Collection
 * @param Closure((int|string) $key, T $value, iterable<T> $collection):(int|string) $function
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
