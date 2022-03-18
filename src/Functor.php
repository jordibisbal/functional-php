<?php

declare(strict_types=1);

namespace j45l\functional;

interface Functor
{
    /**
     * @param  callable(Functor): Functor $callable
     * @return Functor
     */
    public function map(callable $callable): Functor;
}
