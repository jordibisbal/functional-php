<?php
declare(strict_types=1);

namespace j45l\functional\Sequences;

use Iterator;

/**
 * @template T
 * @implements Iterator<int, T>
 */
final class SequenceIterator implements Iterator
{
    /** @var Sequence<T>  */
    private Sequence $sequence;

    /** @var Sequence<T>  */
    private Sequence $initialSequence;

    /** @param Sequence<T> $sequence */
    private function __construct(Sequence $sequence)
    {
        $this->sequence = $sequence;
        $this->initialSequence = $sequence;
    }

    /**
     * @param Sequence<T> $sequence
     * @return SequenceIterator<T>
     */
    public static function create(Sequence $sequence): SequenceIterator
    {
        return new self($sequence);
    }

    public function current(): mixed
    {
        return $this->sequence->value();
    }

    public function next(): void
    {
        $this->sequence = $this->sequence->next();
    }

    public function key(): int
    {
        return $this->sequence->iteration() - 1;
    }

    public function valid(): bool
    {
        return true;
    }

    public function rewind(): void
    {
        $this->sequence = $this->initialSequence;
    }
}