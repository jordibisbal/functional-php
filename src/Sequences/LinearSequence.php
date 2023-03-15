<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

/**
 * @implements Sequence<int|float>
 */
final class LinearSequence implements Sequence
{
    private int|float $value;

    private int|float $increment;

    private int $iteration;

    private function __construct(float|int $start, float|int $increment, int $iteration = 1)
    {
        $this->value = $start;
        $this->increment = $increment;
        $this->iteration = $iteration;
    }

    public static function create(float|int $start, float|int $increment): LinearSequence
    {
        return new self($start, $increment);
    }

    public function next(): Sequence
    {
        return new self($this->value + $this->increment, $this->increment, $this->iteration + 1);
    }

    public function value(): int|float
    {
        return $this->value;
    }

    public function iteration(): int
    {
        return $this->iteration;
    }
}
