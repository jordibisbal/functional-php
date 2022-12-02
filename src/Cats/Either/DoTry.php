<?php

declare(strict_types=1);

namespace j45l\functional\Either;

use Exception;
use j45l\functional\Cats\Either\Reason\BecauseException;
use j45l\functional\Cats\Functors\Functor;

/**
 * @template T
 * @implements Functor<T>
 */
abstract class DoTry implements Functor
{
    /** @phpstan-return DoTry<T> */
    public static function try(callable $fn): DoTry
    {
        try {
            return Success::pure($fn());
        } catch (Exception $exception) {
            return Failure::of(BecauseException::of($exception));
        }
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return DoTry<T|R>
     */
    abstract public function orElse(callable $fn): mixed;

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
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function orElseTry(callable $fn): DoTry
    {
        return $this;
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function andThenTry(callable $fn): DoTry
    {
        return $this;
    }

    /**
     * @return T
     */
    abstract public function getOrFail(string $message = null): mixed;
}
