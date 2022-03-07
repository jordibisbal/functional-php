<?php

declare(strict_types=1);

namespace j45l\functional;

/**
 * @template T
 * @param array<T> $collection
 * @return array<T>
 */
function unindex(array $collection): array
{
    return array_values($collection);
}
