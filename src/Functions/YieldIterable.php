<?php

declare(strict_types=1);

namespace j45l\functional;

use Generator;
use Iterator;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param iterable<string|int> $values Collection
 * @noinspection  PhpPluralMixedCanBeReplacedWithArrayInspection
 */
function yieldIterable(iterable $collection, iterable $values = null): Generator
{
    if ($values === null) {
        foreach ($collection as $key => $value) {
            yield $key => $value;
        }

        return;
    }

    $nextIndex = 0;
    foreach ($values as $value) {
        $index = match (true) {
            $collection instanceof Iterator => also(function () use (&$collection) {
                $collection->next();
            })($collection->current()),
            default =>  also(function () use (&$collection) {
                next($collection);
            })(current($collection)),
        };
        $nextIndex = match (true) {
            is_int($index) => max($index + 1, $nextIndex),
            default => $nextIndex
        };
        yield $index => $value;
    }
}
