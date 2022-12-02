<?php

declare(strict_types=1);

namespace j45l\functional\Cats\DoTry;

use Exception;
use j45l\functional\Cats\DoTry\Reason\BecauseException;
use j45l\functional\Cats\Functors\Functor;
use j45l\functional\Cats\Maybe\Maybe;

/**
 * @template T
 * @implements Functor<T>
 */
abstract class DoTry implements Functor
{
    /**
     * @param callable():T $fn
     * @phpstan-return DoTry<T>
     */
    public static function try(callable $fn): DoTry
    {
        try {
            return Success::pure($fn());
        } catch (Exception $exception) {
            return Failure::because(BecauseException::of($exception));
        }
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return $this|DoTry<R>
     */
    abstract public function orElse(callable $fn): self;

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
     * @phpstan-return Maybe<T>
     */
    abstract public function toMaybe(): Maybe;
}
