<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

use j45l\functional\Cats\Either\Reason\Reason;
use j45l\functional\Cats\Maybe\None;
use RuntimeException;

/**
 * @template Left
 * @template Right
 * @extends Either<Left, Right>
 */
final class Failure extends Either
{
    private function __construct(public readonly Reason $reason)
    {
    }

    /** @return self<Left, Right> */
    public static function because(Reason $reason): Failure
    {
        return new self($reason);
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return self<Left,Result>
     */
    public function andThen(callable $fn): self
    {
        return $this;
    }

    public function getOrElse(mixed $value): mixed
    {
        return $value;
    }

    /**
     * @return T
     */
    public function getOrFail(string $message = null): mixed
    {
        throw new RuntimeException($message ?? 'getOrFail() called upon a Left object.');
    }

    /**
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(callable $fn): self
    {
        return $this;
    }

    /**
     * @template R
     * @param callable(Failure<T>):R $fn
     * @return Either<R>
     */
    public function orElse(callable $fn): Either
    {
        return Either::try(fn () => $fn($this)); /** @phpstan-ignore-line  */
    }

    public function reason(): reason
    {
        return $this->reason;
    }

    /** @return None<T> */
    public function toMaybe(): None
    {
        return None::create();
    }
}
