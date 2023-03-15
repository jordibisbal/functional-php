<?php

declare(strict_types=1);

namespace j45l\functional\Sequences;

/** @template T */
interface Sequence
{
    /** @return T */
    public function value(): mixed;

    /** @return Sequence<T> */
    public function next(): Sequence;

    public function iteration(): int;
}
