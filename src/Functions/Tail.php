<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @phpstan-param iterable<T> $collection Collection
 * @phpstan-return array<T>
 */
function tail(iterable $collection): array
{
    return array_slice((array) $collection, 1, null, true);
}
