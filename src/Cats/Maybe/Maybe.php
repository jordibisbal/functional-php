<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Maybe;

use j45l\functional\Cats\Functors\Functor;
use j45l\functional\Cats\DoTry\DoTry;

/**
 * @template T
 * @implements Functor<T>
 */
abstract class Maybe implements Functor
{
    /**
     * @param T $value $value
     * @return Some<T>
     */
    public static function of(mixed $value): Some
    {
        return Some::pure($value);
    }

    /**
     * @param T|null $value
     * @phpstan-return ($value is null ? None<T> : Some<T>)
     */
    public static function ofNullable(mixed $value): Maybe
    {
        return match (true) {
            is_null($value) => None::create(),
            default => Some::pure($value)
        };
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return self<R|T>
     */
    abstract public function orElse(callable $fn): Maybe;

    /**
     * @template R
     * @param R $value
     * @return R|T
     */
    abstract public function getOrElse(mixed $value): mixed;

    /**
     * @template R
     * @param callable(T):R $fn
     * @return self<R|T>
     */
    abstract public function andThen(callable $fn): mixed;

    /**
     * @return T
     */
    abstract public function getOrFail(string $message = null): mixed;

    /**
     * @template R
     * @param callable(T|null):R $fn
     * @phpstan-return DoTry<R>
     */
    public function try(callable $fn): DoTry
    {
        return DoTry::try(fn () => $fn($this->getOrElse(null)));
    }
}
