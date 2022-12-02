<?php

declare(strict_types=1);

namespace j45l\functional\Either;

use j45l\functional\Cats\Either\Reason\Reason;

/**
 * @template T
 * @extends DoTry<T>
 */
final class Failure extends DoTry
{
    /**
     * @param callable $fn
     * @phpstan-return self<T>
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function map(callable $fn): self
    {
        return $this;
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @phpstan-return $this
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function andThen(callable $fn): self
    {
        return $this;
    }

    /**
     * @template R
     * @param callable(T):R $fn
     * @return R
     */
    public function orElseTry(callable $fn): DoTry
    {
        return DoTry::try(fn () => $fn($this));
    }

    /**
     * @return T
     */
    public function getOrFail(string $message = null): mixed
    {
        throw new RuntimeException($message ?? 'getOrFail() called upon a Left object.');
    }

    private function __construct(public readonly Reason $reason)
    {
    }

    /** @return self<T> */
    public static function of(Reason $reason): Failure
    {
        return new self($reason);
    }
    public function reason(): reason
    {
        return $this->reason;
    }

    public function getOrElse(mixed $value): mixed
    {
        // TODO: Implement getOrElse() method.
    }

    public function orElse(callable $fn): mixed
    {
        // TODO: Implement orElse() method.
    }
}
