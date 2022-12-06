<?php

declare(strict_types=1);

namespace j45l\functional\Tuples;

/**
 * @template T1
 * @template T2
 * @param T1 $first
 * @param T2 $second
 * @return Pair<T1, T2>
 */
function Pair(mixed $first, mixed $second): Pair
{
    return Pair::from($first, $second);
}
