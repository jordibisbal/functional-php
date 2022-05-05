<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

final class LinearSequence implements Sequence
{
    /** @var int|float */
    private $value;

    /** @var int|float */
    private $increment;

    /**
     * @param int|float $start
     * @param int|float $increment
     */
    private function __construct($start, $increment)
    {
        $this->value = $start;
        $this->increment = $increment;
    }

    /**
     * @param int|float $start
     * @param int|float $increment
     */
    public static function create($start, $increment): LinearSequence
    {
        return new self($start, $increment);
    }

    public function next(): Sequence
    {
        return self::create($this->value + $this->increment, $this->increment);
    }

    public function value()
    {
        return $this->value;
    }
}
