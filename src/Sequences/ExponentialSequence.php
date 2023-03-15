<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

/**
 * @implements Sequence<int|float>
 */
final class ExponentialSequence implements Sequence
{
    private int|float $scale;

    private int|float $base;

    private int $iteration;

    private function __construct(float|int $base, float|int $scale, int $iteration = 1)
    {
        $this->scale = $scale;
        $this->base = $base;
        $this->iteration = $iteration;
    }

    public static function create(float|int $base, float|int $scale = 1): ExponentialSequence
    {
        return new self($base, $scale);
    }

    public function value(): float|int
    {
        return $this->scale * ($this->base ** ($this->iteration - 1));
    }

    public function next(): Sequence
    {
        return new self($this->base, $this->scale, $this->iteration + 1);
    }

    public function iteration(): int
    {
        return $this->iteration;
    }
}
