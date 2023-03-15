<?php

declare(strict_types=1);

namespace j45l\functional\Tuples;

/**
 * @template T1
 * @template T2
 */
class Pair
{
    /**
     * @var T1
     */
    private $first;
    /**
     * @var T2
     */
    private $second;

    /**
     * @param T1 $first
     * @param T2 $second
     */
    private function __construct($first, $second)
    {
        $this->first = $first;
        $this->second = $second;
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
