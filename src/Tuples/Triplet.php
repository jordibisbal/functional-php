<?php

declare(strict_types=1);

namespace j45l\functional\Tuples;

/**
 * @template T1
 * @template T2
 * @template T3
 */
class Triplet
{
    /**
     * @var T1
     */
    private mixed $first;
    /**
     * @var T2
     */
    private mixed $second;
    /**
     * @var T3
     */
    private mixed $third;

    /**
     * @param T1 $first
     * @param T2 $second
     * @param T3 $third
     */
    private function __construct(mixed $first, mixed $second, mixed $third)
    {
        $this->first = $first;
        $this->second = $second;
        $this->third = $third;
    }

    /**
     * @param  T1 $first
     * @param  T2 $second
     * @param  T3 $third
     * @return Triplet<T1, T2, T3>
     */
    public static function from(mixed $first, mixed $second, mixed $third): self
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
}
