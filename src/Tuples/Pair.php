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
 */
readonly class Pair
{
    /**
     * @param T1 $first
     * @param T2 $second
     */
    private function __construct(private mixed $first, private mixed $second)
    {
    }

    /**
     * @param  T1 $first
     * @param  T2 $second
     * @return Pair<T1, T2>
     */
    public static function from($first, $second): Pair
    {
        return new self($first, $second);
    }

    /**
     * @return T1
     */
    public function first()
    {
        return $this->first;
    }

    /**
     * @return T2
     */
    public function second()
    {
        return $this->second;
    }

    /**
     * @return array{T1, T2}
     */
    public function toArray(): array
    {
        return [$this->first, $this->second];
    }
}
