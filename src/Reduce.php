<?php

declare(strict_types=1);

namespace j45l\functional;

use Closure;

use function Functional\reduce_left;

/**
 * @phpstan-param iterable<mixed> $collection Collection
 * @phpstan-param Closure(mixed $value, mixed $index, mixed $collection, mixed $initial): mixed $callback
 *                Closure(mixed $value, mixed $index, mixed $collection, mixed $initial)
 * @param null|mixed $initial
 * @return mixed
 */
function reduce(iterable $collection, Closure $callback, $initial = null)
{
    return reduce_left($collection, $callback, $initial);
}
