<?php

declare(strict_types=1);

namespace j45l\functional\Cats\DoTry;

use j45l\functional\Cats\DoTry\Reason\Reason;
use j45l\functional\Cats\Maybe\None;
use RuntimeException;

/**
 * @template T
 * @extends DoTry<T>
 */
final class Failure extends DoTry
{
    private function __construct(public readonly Reason $reason)
    {
    }

    /** @return self<T> */
    public static function because(Reason $reason): Failure
    {
        return new self($reason);
    }

    /**
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
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
     * @return DoTry<R>
     */
    public function orElse(callable $fn): DoTry
    {
        return DoTry::try(fn () => $fn($this)); /** @phpstan-ignore-line  */
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
