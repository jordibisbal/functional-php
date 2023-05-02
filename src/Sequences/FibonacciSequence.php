<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

/**
 * @implements Sequence<int>
 */
final readonly class FibonacciSequence implements Sequence
{
    private function __construct(
        public int $current,
        public int $successor,
        public int $iteration
    ) {
    }

    public static function create(int $start = 1): FibonacciSequence
    {
        return new self($start, self::successor($start), 1);
    }

    private static function successor(int $start): int
    {
        return match(true) {
            $start <= 1 => 1,
            default => (static function ($start) {
                /** @infection-ignore-all */
                $previous = 0;
                $current = 1;

                while ($current <= $start) {
                    [$previous, $current] = [$current, $current + $previous];
                }

                return $current;
            })($start)
        };
    }

    public function next(): Sequence
    {
        return new self(
            $this->successor,
            $this->current + $this->successor,
            $this->iteration + 1
        );
    }

    public function current(): int|float
    {
        return $this->current;
    }

    public function iteration(): int
    {
        return $this->iteration;
    }
}
