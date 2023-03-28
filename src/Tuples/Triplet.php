<?php

declare(strict_types=1);

namespace j45l\functional\Tuples;

/**
 * @template T1
 * @template T2
 * @template T3
 */
readonly class Triplet
{
    /**
     * @param T1 $first
     * @param T2 $second
     * @param T3 $third
     */
    private function __construct(private mixed $first, private mixed $second, private mixed $third)
    {
    }

    /**
     * @param  T1 $first
     * @param  T2 $second
     * @param  T3 $third
     * @return Triplet<T1, T2, T3>
     */
    public static function from(mixed $first, mixed $second, mixed $third): Triplet
    {
        return new self($first, $second, $third);
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
     * @return T3
     */
    public function third()
    {
        return $this->third;
    }

    /**
     * @return array{T1, T2}
     */
    public function toArray(): array
    {
        return [$this->first, $this->second, $this->third];
    }
}
