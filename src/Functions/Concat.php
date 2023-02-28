<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T of int|float
 * @phpstan-param iterable<T> $collection Collection
 */
function concat(iterable $collection): mixed
{
    return fold($collection, fn ($x, $y) => $x . $y, '');
}
