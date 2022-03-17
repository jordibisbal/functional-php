<?php

namespace j45l\functional;

/**
 * @template T
 * @SuppressWarnings(PHPMD.ShortClassName)
 */
final class Id implements Functor
{
    /**
     * @var T
     */
    private $value;

    /**
     * @param T $value
     */
    private function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @param  callable $callable
     * @return Id<T>
     */
    public function map(callable $callable): Functor
    {
        return new self($callable($this->value));
    }

    /**
     * @return T
     */
    public function get()
    {
        return $this->value;
    }
}
