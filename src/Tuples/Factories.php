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

/**
 * @template T1
 * @template T2
 * @template T3
 * @param T1 $first
 * @param T2 $second
 * @param T3 $third
 * @return Triplet<T1, T2, T3>
 */
function Triplet(mixed $first, mixed $second, mixed $third): Triplet
{
    return Triplet::from($first, $second, $third);
}