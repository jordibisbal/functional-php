<?php

declare(strict_types=1);

namespace j45l\functional\Cats\Either;

use j45l\functional\Cats\Either\Reason\Reason;
use j45l\functional\Cats\Maybe\None;
use RuntimeException;
use function j45l\functional\with;

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
     * @template Result
     * @param callable(Failure<Left, Right>):Result $fn
     * @return Either<mixed, Result>
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function orElse(callable $fn): Either
    {
        return with(self::try(fn() => $fn($this)))(static fn (Either $either) => match (true) {
            isSuccess($either) => $either->get(),
            default => $either
        });
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
