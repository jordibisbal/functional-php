<?php

declare(strict_types=1);

Namespace jordibisbal\functional;

use function Functional\reduce_right;

/**
 * @template T,CT
 * @param iterable||CT $collection
 * @param callable $callback
 * @param <T> $initial
 * @return <T>
 * @no-named-arguments
 */
function reduce(iterable $collection, callable $callback, mixed $initial = null): mixed
{
    /** @noinspection PhpParamsInspection */
    return reduce_right($collection, $callback, $initial);
}