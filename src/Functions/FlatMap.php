<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use Traversable;
use function is_iterable as isIterable;
use function is_null as isNull;

/**
 * @template T
 * @template T2
 * @param iterable<T> $collection
 * @param Closure(T $value, int|string $key, iterable<T> $icollection):(Traversable<T2>|array<T2>|T2|null) $function
 * @return array<T2>
 */
function flatMap(iterable $collection, Closure $function): array
{
    $aggregation = [];

    foreach ($collection as $key => $value) {
        $result = $function($value, $key, $collection);

        if (isIterable($result)) {
            foreach ($result as $item) {
                $aggregation[] = $item;
            }
        } elseif (!isNull($result)) {
            $aggregation[] = $result;
        }
    }

    return $aggregation;
}
