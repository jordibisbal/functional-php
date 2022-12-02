<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Functors;

/** @template A */
interface Functor
{
    /**
     * @template B
     * @param callable(A):B $fn
     * @return Functor<B>
     */
    public function map(callable $fn): Functor;
}
