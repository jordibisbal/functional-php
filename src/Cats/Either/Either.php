<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

use Exception;
use j45l\functional\Cats\Either\Reason\BecauseException;
use j45l\functional\Cats\Functors\Functor;
use j45l\functional\Cats\Maybe\Maybe;

/**
 * @template Left
 * @template Right
 * @implements Functor<Right>
 */
abstract class Either implements Functor
{
    /**
     * @param callable():Right $fn
     * @phpstan-return Either<Left,Right>
     */
    public static function try(callable $fn): Either
    {
        try {
            return Success::pure($fn());
        } catch (Exception $exception) {
            return Failure::because(BecauseException::of($exception));
        }
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return $this|Either<Left, Result>
     */
    abstract public function orElse(callable $fn): self;

    /**
     * @template Result
     * @param Result $value
     * @return Result|Right
     */
    abstract public function getOrElse(mixed $value): mixed;

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return self<Left,Result>
     */
    abstract public function andThen(callable $fn): mixed;

    /**
     * @return Right
     */
    abstract public function getOrFail(string $message = null): mixed;

    /**
     * @phpstan-return Maybe<Right>
     */
    abstract public function toMaybe(): Maybe;
}
