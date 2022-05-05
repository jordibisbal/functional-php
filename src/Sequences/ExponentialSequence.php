<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

use function pow;

final class ExponentialSequence implements Sequence
{
    /** @var int|float */
    private $scale;

    /** @var int|float */
    private $base;

    /** @var int */
    private $iteration;

    /**
     * @param int|float $base
     * @param int|float $scale
     * @param int $iteration
     */
    private function __construct($base, $scale, int $iteration = 1)
    {
        $this->scale = $scale;
        $this->base = $base;
        $this->iteration = $iteration;
    }

    /**
     * @param int|float $base
     * @param int|float $scale
     */
    public static function create($base, $scale = 1): ExponentialSequence
    {
        return new self($base, $scale);
    }

    public function value()
    {
        return $this->scale * pow($this->base, $this->iteration - 1);
    }

    public function next(): Sequence
    {
        return new self($this->base, $this->scale, $this->iteration + 1);
    }
}
