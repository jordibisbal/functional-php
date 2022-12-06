<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

use j45l\functional\Cats\Either\Reason\Reason;
use j45l\functional\Cats\Maybe\None;
use RuntimeException;
use function j45l\functional\with;

/**
 * @template Right
 * @extends Either<Right>
 */
final class Failure extends Either
{
    private function __construct(public readonly Reason $reason)
    {
    }

    /** @return self<Right> */
    public static function because(Reason $reason): Failure
    {
        return new self($reason);
    }

    /**
     * @template Result
     * @param callable(Right):Result $fn
     * @return self<Result>
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
     * @never-return
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
     * @template Result
     * @param callable(Failure<Right>):Result $fn
     * @return Either<Result>
     */
    public function orElse(callable $fn): Either
    {
        return with(self::try(fn() => $fn($this)))(static fn (Either $either) => match (true) {
            $either instanceof Success => $either->get(),
            default => $either
        });
    }

    public function reason(): reason
    {
        return $this->reason;
    }

    /** @return None<Right> */
    public function toMaybe(): None
    {
        return None::create();
    }
}
