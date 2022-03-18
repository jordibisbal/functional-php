<?php

namespace j45l\functional;

/**
 * @template T
 * @SuppressWarnings(PHPMD.ShortClassName)
 */
final class Id implements Functor
{
    /**
     * @param  callable(Functor): Functor $callable
     * @return Functor
     */
    public function map(callable $callable): Functor
    {
        return $callable($this);
    }
}
